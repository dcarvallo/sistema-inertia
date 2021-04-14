<template>
<app-layout>
<form @submit.prevent="crearusuario" enctype="multipart/form-data" @keydown.enter.prevent>
    
<div class="bg-white altura">
  <TabView class="p-4 bg-white ">
    <TabPanel header='Información de usuario'>
      <div class="grid grid-cols-2 gap-4 p-3">
        <div >
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombres">Nombres*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" id="nombres" v-model="form.nombres" placeholder="Ejem. Juan" autofocus>
            <div v-if="$page.props.errors.nombres" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.nombres }}</div>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="apellidos">Apellidos*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.apellidos" placeholder="Ejem. Perez Perez">
            <div v-if="$page.props.errors.apellidos" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.apellidos }}</div> 
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="username">Nombre de Usuario*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.username" placeholder="Ejem. jperez"/>
            <div v-if="$page.props.errors.username" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.username }}</div> 
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="email">Email*</label>
            <input type="email" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.email" placeholder="Ejem. jperez@empresa.com">
            <div v-if="$page.props.errors.email" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.email }}</div> 
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="activo">Activo*</label>
            <select class="block bg-white border border-gray-400 hover:border-gray-500  mb-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="form.activo">
              <option value="1"  selected>Si</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="password">Password*</label>
            <Password weakLabel="debil" mediumLabel="Medio" strongLabel="Fuerte" type="password" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.password"  placeholder="Password">
                  <template #header>
                    <h6>Escribe una contraseña</h6>
                  </template>
                  <template #footer="sp">
                    {{sp.level}}
                    <hr />
                    <p class="p-mt-2">Políticas</p>
                    <ul class="p-pl-2 p-ml-2 p-mt-0" style="line-height: 1.5">
                        <li>Al menos una minúscula</li>
                        <li>Al menos una mayúscula</li>
                        <li>Al menos un número</li>
                        <li>Minimo 8 caracteres</li>
                    </ul>
                  </template>
                </Password>
            <!-- <input type="password" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.password" placeholder="Ingrese password"> -->
            <div v-if="$page.props.errors.password" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.password }}</div> 
          </div>
        </div>
        <div>
          <label class="block tracking-wide text-grey-darker font-bold mb-2" for="">Fotografía</label>
          <div class="text-center">
            <img :src="enlace" class="text-center" style="width: 10em" alt="Imagen de usuario">
          </div>
          <br>
          <input type="file" @change="onFileChange" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" accept="image/*"/>
          <div v-if="$page.props.errors.imagen" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.imagen }}</div> 
        
        </div>
      </div>
    </TabPanel>

      <TabPanel header='Roles'>
      <div class="p-3">
        <label v-if="expand" @click="expand = !expand" :style="{cursor: 'pointer'}" @click.prevent="expandirTodos">Contraer todos</label>
        <label v-else @click="expand = !expand" :style="{cursor: 'pointer'}" @click.prevent="expandirTodos">Expandir todos</label>

        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6">
          <div class="my-2" v-for="(categoria,index) in roles" :key="index">
            <label class="bg-cyan w-100 rounded px-1" @click.prevent="funcion(index)" :style="{cursor: 'pointer'}">
              <i v-if="nombres.includes(index)" class="far fa-minus-square"></i>
              <i v-else class="far fa-plus-square"></i>
              <span class="bold">  {{index}} </span>
            </label>
              <div v-for="elemento in categoria" :key="elemento.id"> 
                <transition name="fade">
                  <label v-if="nombres.includes(elemento.category)"  :style="{cursor: 'pointer'}">
                    <input type="checkbox" :id="elemento.id" :value="elemento.name" v-model="rol.guard_name">
                    <span>{{elemento.name}}</span> 
                  </label>
                </transition>
              </div>
            </div> 
          </div>
        </div>
      </TabPanel>
      </TabView>
      <div class="text-right">
      <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" ><i class="far fa-save"></i> Guardar</button>
    </div>
    </div>
  
  </form>
    
</app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Password from 'primevue/password';

export default {
  props: ['roles'],
  components: { AppLayout, Password, TabPanel, TabView },
  data(){
    return{
      value: null,
      message: '',
      dato: '',
      empselect:'',
      enlace: '/storage/usuariodef/avatar.png',
      form: this.$inertia.form({
        nombres: '',
        apellidos: '',
        username: '',
        activo: 1,
        email: '',
        password: '',
        imagen: '',
      }),
      rol: {
        guard_name: [],
      },
      nombres: [],
      test:[],
      expand: true,
    }
  },
  created() {
    for(var k in this.roles) {
        this.test.push(k);
      }
      this.nombres = this.test;
  },
  methods:{
    nombresApellidosCi ({ nombres, ap_paterno, ap_materno, ci }) {
      return `${nombres} ${ap_paterno} ${ap_materno} - CI: ${ci}`
    },
    expandirTodos()
    {
      if(this.expand)
      {
        this.nombres = this.test;
      }
      else
        this.nombres = [];
    },
    funcion(el)
    {
      if(this.nombres.includes(el))
      {
        let index = this.nombres.indexOf(el);
        if (index > -1) {
          this.nombres.splice(index, 1);
        }
      }
      else{
        this.nombres.push(el)
      }
    },
    onFileChange(e) {
      this.usuario.imagen = e.target.files;
      this.enlace = URL.createObjectURL(this.usuario.imagen );
    },
    crearusuario()
    {
      let formData = new FormData();
      formData.append('nombres', this.form.nombres);
      formData.append('apellidos', this.form.apellidos);
      formData.append('username', this.form.username);
      formData.append('email', this.form.email);
      formData.append('activo', this.form.activo);
      formData.append('password', this.form.password);
      formData.append('imagen', this.form.imagen);
      formData.append('roles', this.rol.guard_name);
      this.$inertia.post('/users/store', formData, {
        onSuccess : () => {
          this.form.reset()
          this.rol.guard_name= []
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
      })
    }
  }
}
</script>
<style>
.p-password input {
    width: 100%
}
.p-password {
  padding: 0;
  border: 1px solid black;
}
</style>