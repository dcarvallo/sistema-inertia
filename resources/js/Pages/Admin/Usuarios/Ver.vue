<template>
<app-layout>

<TabView class="p-2 altura bg-white" >
  <TabPanel header='Información de usuario'>
      <div>
        <div>
          <h5 class="text-center text-xl font-bold">{{ usuariomod.nombres }} {{usuariomod.apellidos }} </h5>
        </div>
      <div id="usuarioedit">

        <div>
          <p class="mb-0"> {{usuariomod.nombres}}  </p>
          <hr class="border-gray-900">
          <label class="block tracking-wide text-grey-darker font-bold mb-2">Nombres</label>
        </div>
        <div>
          <p class="mb-0"> {{usuariomod.apellidos}}  </p>
          <hr class="border-gray-900">
          <label class="block tracking-wide text-grey-darker font-bold mb-2">Apellidos</label>
        </div>
        <div>
          <p class="mb-0"> {{usuariomod.username}}  </p>
          <hr class="border-gray-900">
          <label class="block tracking-wide text-grey-darker font-bold mb-2" for="username">Nombre de usuario</label>
        </div>

        <div>
          <p class="mb-0"> {{usuariomod.email ? usuariomod.email : 'N/A'}}  </p>
          <hr class="border-gray-900">
          <label class="block tracking-wide text-grey-darker font-bold mb-2" for="username">Email</label>
        </div>

        <div>
          <p class="mb-0"> {{usuariomod.activo ? 'Si' : 'No'}}  </p>
          <hr class="border-gray-900">
          <label class="block tracking-wide text-grey-darker font-bold mb-2" for="username">Activo</label>
        </div>

        <div>
          <p class="mb-0"> {{usuariomod.created_at}}  </p>
          <hr class="border-gray-900">
          <label class="block tracking-wide text-grey-darker font-bold mb-2" for="username">Fecha Creacion</label>
        </div>
        

        <div class="form-group col-md-12 px-0">
          <label class="block tracking-wide text-grey-darker font-bold mb-2" for="fotografia">Fotografia de usuario</label><br>
          <div class="text-center">
          <img :src="enlace" class="img" style="width: 15em" alt="Imagen de usuario">
          </div>
        </div>
        
      </div>
    
  </div>
  </TabPanel>
  <TabPanel header='Roles'>
    <div>
        <h5 class="text-center text-xl font-bold">Roles</h5>
      <div>
        <li v-for="(rol, index) in rolesusuario" :key="index">
          {{rol.name}}
        </li>
      </div>
    </div>
  </TabPanel>
</TabView>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
export default {
  components: {
      TabView,
      TabPanel,
      AppLayout
    },
  props: ['usuario', 'rolesusuario'],
  data(){
    return{
      expand: false,
      nombres: [],
      errors: [],
      enlace: '/storage/'+this.usuario.fotografia,
      usuariomod: this.usuario,
      rolesSeleccionados: [],
    }
  },
  created(){
    
    for(let i=0; i< this.rolesusuario.length; i++)
    {
      this.rolesSeleccionados[i] = this.rolesusuario[i].name; 
    }
  },
  methods:{
    setSelected(tab) {
      this.selected = tab;
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

  },
  
}
</script>