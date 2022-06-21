<template>
<app-layout>
<div class="text-center font-bold">
  <h1>{{ form.nombres }} {{form.apellidos }} </h1>
</div>
  <TabView  class="bg-white">
    <TabPanel header='Información de usuario'>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3">
      <div class="p-2">
      <form @submit.prevent="editarusuarioprin" enctype="multipart/form-data" @keydown.enter.prevent>
        <div class="border rounded border-gray-300 p-2" id="usuarioedit">
                
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombres">Nombres</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.nombres" placeholder="Nombres" autofocus>
            <div v-if="$page.props.errors.nombres" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.nombres }}</div>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="apellidos">Apellidos</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.apellidos" placeholder="Apellidos">
            <div v-if="$page.props.errors.apellidos" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.apellidos }}</div>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="username">Nombre de Usuario</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.username"  placeholder="Nombre de usuario"/>
            <div v-if="$page.props.errors.username" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.username }}</div>
          </div>

          
          <div class="form-group col-md-3 px-0">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="email">Activo</label>
            <select class="block bg-white border border-gray-400 hover:border-gray-500 mb-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="form.activo">
                <option value="1" >Si</option>
                <option value="0" >No</option>
            </select>
          </div>
          

          <div class="form-group col-md-12 px-0 text-center">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="fotografia">Fotografía de usuario</label><br>
            <div class="flex justify-center">
            <img :src="enlace" style="width: 15em" alt="Imagen de usuario">
            </div>
            <br>
            <input type="file" @change="onFileChange" class="form-control" name="imagen" accept="image/*"/>

            <div v-if="$page.props.errors.imagen" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ $page.props.errors.imagen }}</div>
          </div>
          
          <div class="text-right">
            <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" >Guardar</button>
          </div>
        </div>
      </form>
    </div>
      <div class="p-2">

        <div class="row"> 

        <div class="col-md-12">
          <div>
            <h5>Editar correo</h5>
          </div>
          <div>
            <form @submit.prevent="updateemail">
              <div class="form-group">
                <div class="flex gap-2 content-center">
                  <input type="email" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="usuario.email" placeholder="email">
                  <button class="select-none bg-blue-600 text-white rounded p-1 hover:bg-blue-800" >{{botonmail}}</button>
                </div>
                <p class="alert bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.email">{{$page.props.errors.email}}</p>
                
              </div>
            </form>

          </div>
        </div>

        <div class="col-md-12">
            <div>
              <h5>Restablecer password</h5>
            </div>
            <div>
              <form @submit.prevent="updatepass">
                <div class="flex gap-2">
                <Password weakLabel="debil" mediumLabel="Medio" strongLabel="Fuerte" type="password" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="usuario_pass"  placeholder="Password">
                  <template #header>
                    <h6>Escribe una contraseña</h6>
                  </template>
                  <template #footer="sp">
                    {{sp.level}}
                    <hr />
                    <p class="my-2 font-bold">Políticas</p>
                    <ul class="p-pl-2 p-ml-2 p-mt-0" style="line-height: 1.5">
                        <li>Al menos una minúscula</li>
                        <li>Al menos una mayúscula</li>
                        <li>Al menos un número</li>
                        <li>Minimo 8 caracteres</li>
                    </ul>
                  </template>
                </Password>
                <button class="select-none bg-blue-600 text-white rounded p-1 hover:bg-blue-800" >{{botonpass}}</button>
                </div>
                <p v-if="$page.props.errors.password" class="alert bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{$page.props.errors.password}}</p>
              
              </form>
            </div>
        </div>
        </div>
      </div>
    </div>
  </TabPanel>

  <TabPanel header='Roles'>
      <div class="p-1">
        <form @submit.prevent="updaterol">
        <label class="bg-blue-700 text-white p-2 border border-gray-500 rounded cursor-pointer " @click.prevent="expandirTodos"> {{expand ? 'Contraer todos' : 'Expandir todos'}}</label>
        
        <div class="row mt-4">
          <div class="col-md-2 my-2" v-for="(categoria,index) in roles" :key="index">
              <label class="bg-gray-700 text-white w-full rounded p-1 cursor-pointer" @click.prevent="funcion(index)">
                <i :class=" nombres.includes(index) ? 'pi pi-minus-circle' : 'pi pi-plus-circle'"></i>
                <span class="bold ml-1">  {{index}} </span>
              </label>
                <div v-for="elemento in categoria" :key="elemento.id"> 
                  <transition name="fade">
                    <label v-if="nombres.includes(elemento.category)" class="cursor-pointer">
                      <input type="checkbox" :id="elemento.id" :value="elemento.name" v-model="rolesSeleccionados">
                      <span>{{elemento.name}}</span> 
                      </label>
                  </transition>
                </div>
            </div> 
          </div>
        <br>
        <div class="text-right">
          <button class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" >Guardar</button>
        </div>
        </form>
    </div>
  </TabPanel>
  </TabView>

  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Password from 'primevue/password';
export default {
  components: { TabView, TabPanel, AppLayout, Password },
  props: ['usuario','roles','rolesusuario'],
  data(){
    return{
      botonmail: 'Guardar',
      botonpass: 'Guardar',
      expand: false,
      usuario_pass: this.usuario.password,
      nombres: [],
      test:[],
      errors: [],
      enlace: '/storage/'+this.usuario.fotografia,
      form: this.usuario,
      rolesSeleccionados: [],
    }
  },
  created(){
    for(let i=0; i< this.rolesusuario.length; i++)
    {
      this.rolesSeleccionados[i] = this.rolesusuario[i].name; 
    }
    for(var k in this.roles) {
        this.test.push(k);
      }
  },
  methods:{
    expandirTodos()
    {
      this.expand = !this.expand;
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
      this.form.imagen = e.target.files[0];
      this.enlace = URL.createObjectURL(e.target.files[0] );
    },
    updateemail() {
        this.$inertia.put('/users/um/'+this.usuario.id, { email: this.usuario.email }, {
          onSuccess : () => {
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
        
        } )
    },
    updatepass() {
        this.$inertia.put('/users/up/'+this.usuario.id,{password: this.usuario_pass}, 
        {
          onSuccess : () => {
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
        })
    },
    editarusuarioprin() {
      console.log(this.form)
      
      this.$inertia.post('/users/'+this.usuario.id, {
        _method: 'put',
        data: this.form
      }, {
        onSuccess : () => {
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
        onReject: (e) => {
          console.log(e)
        }
      })

    },
    updaterol() {
      let formData = new FormData();
      if(this.rolesSeleccionados.length > 0){
        formData.append('roles', this.rolesSeleccionados);
      }
      else {
        formData.append('roles', null);
      }
      console.log(this.rolesSeleccionados)
        this.$inertia.put('/users/ur/'+this.usuario.id, { roles: this.rolesSeleccionados }, {
          onSuccess : () => {
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
        })
    },

  },
  
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