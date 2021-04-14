<template>
<app-layout>
  <form @submit.prevent="editarrol" @keydown.enter.prevent>
    <div class="grid grid-cols-1 md:grid-cols-2">
      <div>
        <div class="form-group">
            <label class="block tracking-wide text-grey-darker  font-bold mb-2">Nombre*</label>
            <input class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" type="text" v-model="form.name" autofocus>
            <div v-if="$page.props.errors.name" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{$page.props.errors.name}}</div>
        </div>
        <div class="form-group">
            <label class="block tracking-wide text-grey-darker  font-bold mb-2">Descripcion*</label>
            <textarea class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" name="description" type="text" v-model="form.description"></textarea>
            <div v-if="$page.props.errors.description" class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{$page.props.errors.description}}</div>
        </div>
        <div class="form-group">
          <div class="d-flex justify-content-between">
            <label class="block tracking-wide text-grey-darker  font-bold mb-2"> Categoria*</label> 
          </div>
          
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
      
      <div class="bg-white">
        <div class=" md:flex">
        <div class="text-center font-bold">
          <h5>Permisos</h5>
        </div>
        <div class="w-full md:w-2/3 xl:w-4/5 border-r-2 p-2">
          <div class="col-md-9">
            <label v-if="expand" @click="expand = !expand" :style="{cursor: 'pointer'}" @click.prevent="expandirTodos">Contraer todos</label>
            <label v-else @click="expand = !expand" :style="{cursor: 'pointer'}" @click.prevent="expandirTodos">Expandir todos</label>
            <div class="grid grid-cols-2 xl:grid-cols-4 2xl:grid-cols-6 gap-4">

              <div class="col-md-2 my-2" v-for="(categoria,index) in permisos2" :key="index" > 
                <label class="bg-cyan w-100 rounded px-1" @click.prevent="funcion(index)" :style="{cursor: 'pointer'}">
                  <i v-if="nombres.includes(index)" class="far fa-minus-square"></i>
                  <i v-else class="far fa-plus-square"></i>
                  <span class="bold">  {{index}} </span>
                </label>
                <div v-for="elemento in categoria" :key="elemento.id"> 
                  <transition name="fade">
                    <label v-if="nombres.includes(elemento.category)"  :style="{cursor: 'pointer'}">
                      <input type="checkbox" :id="elemento.id" :value="elemento.name" v-model="perseleccionaados">
                      <span>{{elemento.name}}</span> 
                      </label>
                  </transition>
                </div>
              </div> 
            </div>
          </div>
          </div>
          <div class="w-full md:w-1/3 xl:w-1/5 p-2">
            <div class="text-center font-bold"> Permisos seleccionados</div>
              <ul>
                <li v-for="(item, index) in perseleccionaados" :key="index">
                  <span>{{item}}</span> <br>
                </li>
              </ul>
          </div>
        </div>
      </div>
    
      <div class="text-right">
        <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" >Guardar</button>
      </div>
    </form>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Dropdown from 'primevue/dropdown';
export default {
  props: ['permisos2','rol', 'permisosseleccionados','categorias'],
  components: { AppLayout, Dropdown },
  data(){
    return{
      form: this.rol,
      nombres: [],
      test: [],
      expand: true,
      nueva: false,
      value: this.rol.category,
      perseleccionaados:[],
    }
  },
  created(){
    if(this.rol.special == null){
      this.rol.special = '';
    }

    for(var k in this.permisos2) {
        this.test.push(k);
      }

    for(let i=0; i< this.permisosseleccionados.length; i++)
    {
      this.perseleccionaados[i] = this.permisosseleccionados[i].name; 
    }

    this.nombres = this.test;
  },
  methods:{
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
    editarrol()
    {
      let formData = new FormData();
      formData.append('name', this.form.name);
      formData.append('description', this.form.description);
      if(this.nueva)
      {
        formData.append('category', this.form.category);
      }else if(!this.nueva && this.form.category != null)
      {
        formData.append('category', this.form.category);
      }
      formData.append('permisos', this.perseleccionaados);
      formData.append('_method', 'put');
      this.$inertia.post('/roles/'+this.rol.id, formData ,{
        onSuccess : () => {
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