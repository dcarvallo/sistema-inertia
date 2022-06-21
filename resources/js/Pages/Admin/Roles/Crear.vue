<template>
<app-layout>
  <form @keydown.enter.prevent>

    <div class="=place-items-center grid grid-cols-1 md:grid-cols-2">
      <div class="place-items-center">
        <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2">Nombre*</label>
            <input class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" type="text" name="name" v-model="form.name" autofocus>
            <div v-if="$page.props.errors.name" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{$page.props.errors.name}}</div>
        </div>
        <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2">Descripcion*</label>
            <textarea class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" type="text" name="description" v-model="form.description"></textarea>
              <div v-if="$page.props.errors.description" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{$page.props.errors.description}}</div>
        </div>
        <div class="form-group">
          <label class="block tracking-wide text-grey-darker font-bold mb-2">Categoria*</label>
          
            <dropdown 
            v-model="form.category" 
            :options="categorias" 
            :editable="true"
            placeholder="Selecciona o crea nueva categoria y presione enter"
           
            class="bg-white border border-gray-700 rounded"
            >
            </dropdown>
            
            <div v-if="$page.props.errors.category" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{$page.props.errors.category}}</div>
          </div>

      </div>
    </div>
      <br>
        <div class="bg-white md:flex">
          <div class="w-full md:w-2/3 xl:w-4/5 border-r-2 p-2">
          <div class="text-center font-bold">
            <h5>Permisos</h5>
          </div>
          <div class="my-2">
            <label class="bg-blue-700 text-white p-2 border border-gray-500 rounded cursor-pointer" @click.prevent="expandirTodos">{{expand ? 'Contraer todos' : 'Expandir'}}</label>
          </div>
          <transition name="fade">
          <div class="grid grid-cols-2 xl:grid-cols-4 2xl:grid-cols-6 gap-4">
            <div class="my-2" v-for="(categoria,index) in permisos2" :key="index">
              <label class="bg-gray-700 text-white w-full rounded p-1" @click.prevent="funcion(index)" :style="{cursor: 'pointer'}">
                <i :class="nombres.includes(index) ? 'pi pi-minus-circle' : 'pi pi-plus-circle' "></i>
                <span class=" font-bold ml-1">  {{index}} </span>
              </label>
              <div v-for="elemento in categoria" :key="elemento.id"> 
                <transition name="fade">
                  <label v-if="nombres.includes(elemento.category)" :style="{cursor: 'pointer'}">
                    <input type="checkbox" :id="elemento.id" :value="{'nombre':elemento.name,'descripcion':elemento.description}" v-model="permiso.name">
                    <span class="pl-1">{{elemento.name}}</span> 
                  </label>
                </transition>
              </div>
            </div> 
          </div>
            </transition>
          </div>
          <div class="w-full md:w-1/3 xl:w-1/5 p-2">
            <div class="text-center font-bold"> Permisos seleccionados</div>
            <ul>
              <li v-for="(item, index) in permiso.name" :key="index">
                <strong>{{item.nombre}}</strong> <br/> 
                <span> {{item.descripcion}}</span>
              </li>
            </ul>
          </div>
        </div>
    
    <div class="text-right">
      <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" @click.prevent="crearrol">Guardar</button>
    </div>
  </form>
    
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Dropdown from 'primevue/dropdown';
export default {
  props: ['permisos2', 'categorias'],
  components: { AppLayout, Dropdown},
  data(){
    return{
      form: this.$inertia.form({
        name: '',
        description: '',
        category: '',
      }),
      test:[],
      expand: true,
      nombres: [],
      permiso: {
        name: [],
      },
    }
  },
  created(){
    for(var k in this.permisos2) {
      this.test.push(k);
      }
    this.nombres = this.test;
  },
  methods:{
    
    expandirTodos()
    {
      this.expand = !this.expand
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
    crearrol()
    {
      let formData = new FormData();
      formData.append('name', this.form.name);
      formData.append('description', this.form.description);
      formData.append('category', this.form.category);
      let arraypermisos = [];
      this.permiso.name.forEach(function(elemento){
        arraypermisos.push(elemento.nombre);
      });
      formData.append('permisos', arraypermisos);
      
      this.$inertia.post('/roles/store', formData, {
        onSuccess : () => {
          this.form.reset()
          this.permiso.name = []
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