<template>
<app-layout>

  <form @keydown.enter.prevent>

        <div>
            <h5><strong> Permiso </strong></h5>
        </div>
        <div>
            <div class="form-group">
                <label>Nombre*</label>
                <input class="form-control" type="text" v-model="permisomod.name" autofocus>
                <label class="alert-danger py-0" v-if="errors.name" >{{errors.name[0]}}</label>
            </div>
            <div class="form-group">
                <label>Descripcion*</label>
                <textarea class="form-control" type="text" v-model="permisomod.description"></textarea>
                <label class="alert-danger py-0" v-if="errors.description" >{{errors.description[0]}}</label>
            </div>
            <div class="form-group">
                <label>Categoria*</label>
                <input class="form-control" type="text" v-model="permisomod.category">
                <label class="alert-danger py-0" v-if="errors.category" >{{errors.category[0]}}</label>
            </div>
          </div>
    
    <div class="text-right">
      <button type="submit" class="select-none btn btn-primary" @click.prevent="editarpermiso">Actualizar</button>
    </div>
  </form>
    
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';

export default {
  components: { AppLayout },
  props: ['permiso'],
  data(){
    return{
      permisomod: this.permiso,
      errors: [],
    }
  },
  created(){

  },
  methods:{
    editarpermiso()
    {
      this.errors = [];
      let formData = new FormData();
      formData.append('name', this.permisomod.name);
      formData.append('description', this.permisomod.description);
      formData.append('category', this.permisomod.category);
      formData.append('_method', 'put');
      axios.post('/permisos/'+this.permiso.id, formData)
      .then(res => {
        console.log(res);
        let datos = res.data;
        toast.fire({
          icon: datos[1].type,
          background: datos[1].background,
          title: datos[1].title+' '+datos[1].message
        })
      })
      .catch(error => {
        let datos = error.data;
        console.log(datos);
        if(error.response.status == 422){
            this.errors = error.response.data.errors;
            toast.fire({
              icon: datos[1].type,
              background: datos[1].background,
              title: 'Error en formulario, revise'
            })
          }
        if(datos){
          toast.fire({
            icon: datos[1].type,
            background: datos[1].background,
            title: datos[1].title+' '+datos[1].message
          })
        }
      })
    }
  }
}
</script>