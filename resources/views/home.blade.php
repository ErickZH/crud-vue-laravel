@extends('template.layout')
@section('title', 'Home')
@section('content')
	<div class="container">
		<div class="columns personal-menu text-center vertical-center margin0">
			<div class="column">
				Zona de pruebas
			</div>
		</div>
		<div class="columns margin0 tile">
			<div class="column is-2 line-der">
				<aside class="menu">
					<p class="menu-label">
						Menú Principal
					</p>
					<ul class="menu-list">
						<li @click="menu=0" class="hand-option">
							<a :class="{'is-active' : menu==0 }">Dashboard</a>
						</li>
						<li @click="menu=1" class="hand-option">
							<a :class="{'is-active' : menu==1 }">Departamentos</a>
						</li>
						<li @click="menu=2" class="hand-option">
							<a :class="{'is-active' : menu==2 }">Cargos</a>
						</li>
						<li @click="menu=3" class="hand-option">
							<a :class="{'is-active' : menu==3 }">Empleados</a>
						</li>
					</ul>
				</aside>
			</div>
			<div class="column personal-content" v-if="menu==0">
				<div class="columns text-center">
					<div class="column">
						<h3>Dashboard</h3>
					</div>
				</div>
				<div class="columns text-center">
					<div class="column">
						<h1>Bienvenido</h1>
					</div>
				</div>
			</div>
			<div class="column" v-if="menu==1">
				<div class="columns">
					<div class="column text-center">
						<h3>Departamentos</h3>
					</div>
					<div class="column">
						<a class="button is-success" @click="openModal('departure', 'create')">Agregar Departmento</a>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div v-if="!departures.length">
							No hay departamentos
						</div>
						<table v-else class="table">
							<thead>
								<th>#</th>
								<th>Titulo</th>
							</thead>
							<tbody>
								<tr v-for="departure in departures">
									<td>@{{ departure.id }}</td>
									<td>@{{ departure.title }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="column" v-if="menu==2">
				<div class="columns">
					<div class="column text-center">
						<h3>Cargos</h3>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						Tabla Cargos
					</div>
				</div>
			</div>
			<div class="column" v-if="menu==3">
				<div class="columns">
					<div class="column text-center">
						<h3>Empleado</h3>
					</div>
					<div class="column">
						Tabla Empleados
					</div>
				</div>
			</div>
		</div>
		<div class="columns margin0 text-center vertical-center personal-menu">
			<div class="column">Empleados 0</div>
			<div class="column">Departamentos 0</div>
			<div class="column">Cargo 0</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal" :class="{'is-active' : modalGeneral}">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="content">
				<h3 class="text-center">@{{ titleModal }}</h3>
				<div class="field">
					<label class="label">@{{ messageModal }}</label>
					<p class="control" v-if="modalDeparture!=0">
						<input class="input" placeholder="Departmento" v-model="titleDeparture" v-if="modalDeparture==1">
					</p>
					<div v-show="errorTitleDeparture" class="columns text-center">
						<div class="column text-center text-danger">
							El nombre del Departmento mo puede estar vacio
						</div>
					</div>
					<div class="columns button-content">
						<div class="column">
							<a class="button is-success" @click="createDeparture()" v-if="modalDeparture==1">Aceptar</a>
						</div>
						<div class="column">
							<a class="button is-danger" @click="closeModal()">Cancelar</a>
						</div>
					</div>
				</div>
			</div>
			<button class="modal-close" @click="closeModal()"></button>
		</div>
	</div>
@endsection
@section('js')
	<script>
		let elemento = new Vue({
			el: '.app',
			data: {
				menu:0,
				modalGeneral: 0,
				titleModal: '',
				messageModal: '',
				modalDeparture: 0,
				titleDeparture: '',
				errorTitleDeparture: 0,
				departures: []
			},
			methods: {
				closeModal() 
				{
					this.modalGeneral = 0;
					this.titleModal = '';
					this.messageModal = '';
				},
				createDeparture() 
				{
					if (this.titleDeparture == '') 
					{
						this.errorTitleDeparture = 1;

						return;
					}

					let me = this;

					// Implementacion de axios

					axios.post('{{ route('departurecreate') }}', {
						'title': this.titleDeparture
					})
					.then(function(response)
					{
						me.titleDeparture = '';
						me.errorTitleDeparture = 0;
						me.modalDeparture = 0;
						me.closeModal();
					})
					.catch(function(error)
					{
						console.log(error);
					});
				},
				openModal(type, action, data = [])
				{
					switch(type)
					{
						case "departure":
						{
							switch(action){
								case 'create':
								{
									this.modalGeneral = 1;
									this.titleModal = 'Creación de Departmento';
									this.messageModal = 'Ingrese el titulo del departamento';
									this.modalDeparture = 1;
									this.titleDeparture = '';
									this.errorTitleDeparture = 0;
									break;
								}
								case 'update':
								{
									break;
								}
								case 'delete':
								{
									break;
								}
							}
							break;
						}
						case 'position':
						{
							switch(action) {
								case 'create':
								{
									break;
								}
								case 'update':
								{
									break;
								}
								case 'delete':
								{
									break;
								}
							}

							break;
						}

						case 'employee':
						{
							switch(action) {
								case 'create':
								{
									break;
								}
								case 'update':
								{
									break;
								}
								case 'delete':
								{
									break;
								}
							}

							break;
						}
					}
				},
				allQuery() {
					let me = this;

					axios.get('{{ route('allQuery') }}')
					.then(function(response) {
						let answer = response.data;

						me.departures = answer.departures;
					})
					.catch(function (error) {
						console.log(error);
					});
				}
			},
		})
	</script>
@endsection