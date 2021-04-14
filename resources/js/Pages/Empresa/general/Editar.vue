<template>
  <app-layout>
    <div class="content mb-4 bg-white p-3 rounded altura">
      <form @submit.prevent="editarempresa()" enctype="multipart/form-data" @keydown.enter.prevent>
        <h5>Información Principal</h5>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-2">
          <div class="p-2">
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Nombre de Empresa*</label>
              <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.nombre" placeholder="Nombre Empresa" autofocus>
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.nombre" >{{errors.nombre[0]}}</label>
            </div>
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="descripcion">Descripción*</label>
              <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.descripcion" placeholder="descripcion"></textarea>
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.descripcion" >{{errors.descripcion[0]}}</label>
            </div>
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="rubro">Rubro*</label>
              <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.rubro" placeholder="rubro">
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.rubro" >{{errors.rubro[0]}}</label>
            </div>
                  
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">NIT*</label>
              <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.nit" placeholder="nit">
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.nit" >{{errors.nit[0]}}</label>
            </div>
            
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Propietario*</label>
              <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.propietario" placeholder="propietario">
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.propietario" >{{errors.propietario[0]}}</label>
            </div>
                  
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="descripcion">Misión*</label>
              <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.mision" placeholder="mision"></textarea>
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.mision" >{{errors.mision[0]}}</label>
            </div>
            <div class="form-group">
              <label class="block tracking-wide text-grey-darker font-bold mb-2" for="descripcion">Visión*</label>
              <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.vision" placeholder="vision"></textarea>
              <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.vision" >{{errors.vision[0]}}</label>
            </div>
          </div>
          <div class="p-2">
            <h5>Información de Contacto</h5>
            <hr>
              <div class="form-group">
                <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Dirección*</label>
                <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.direccion" placeholder="direccion">
                <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.direccion" >{{errors.direccion[0]}}</label>
              </div>
            
              <div class="form-group">
                <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Teléfonos*</label>
                <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.telefono" placeholder="telefono">
                <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.telefono" >{{errors.telefono[0]}}</label>
              </div>

              <div class="form-group">
                <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Email*</label>
                <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.email" placeholder="email">
                <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.email" >{{errors.email[0]}}</label>
              </div>
              <div class="form-group">
                <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Fecha de Creación de la Empresa*</label>
                <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="mod_empresa.fecha_creacion" placeholder="fecha_creacion">
                <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.fecha_creacion" >{{errors.fecha_creacion[0]}}</label>
              </div>
              <div>
                <label class="block tracking-wide text-grey-darker font-bold mb-2" for="">Fotografía</label>
                <div class="text-center">
                  <img :src="enlace" class="text-center" style="width: 10em" alt="Imagen de empresa">
                </div>
                <br>
                <input type="file" @change="onFileChange" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" name="imagen_empresa" accept="image/*"/>
                <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="errors.imagen_empresa" >{{errors.imagen_empresa[0]}}</label> 
              </div>
            </div>              
          </div>
        <div class="flex justify-end">
          <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800">Guardar</button>
        </div>
      </form>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout';
export default {
  props: ['empresa'],
  components: { AppLayout },
  data() {
    return {
      mod_empresa: this.empresa,
      errors: [],
      enlace: this.empresa.imagen_empresa ? '/storage/'+this.empresa.imagen_empresa : "/storage/usuariodef/avatar.png",
    };
  },
  methods: {
    onFileChange(e) {
      this.mod_empresa.imagen_empresa = e.target.files[0];
      this.enlace = URL.createObjectURL(this.mod_empresa.imagen_empresa);
    },
    editarempresa() {
      this.errors = [];
      let formData = new FormData();
      formData.append("nombre", this.mod_empresa.nombre);
      formData.append("descripcion", this.mod_empresa.descripcion);
      formData.append("rubro", this.mod_empresa.rubro);
      formData.append("mision", this.mod_empresa.mision);
      formData.append("vision", this.mod_empresa.vision);
      formData.append("direccion", this.mod_empresa.direccion);
      formData.append("nit", this.mod_empresa.nit);
      formData.append("propietario", this.mod_empresa.propietario);
      formData.append("telefono", this.mod_empresa.telefono);
      formData.append("email", this.mod_empresa.email);
      formData.append("fecha_creacion", this.mod_empresa.fecha_creacion);
      formData.append("imagen_empresa", this.mod_empresa.imagen_empresa);
      formData.append("_method", "put");
      axios.post("/empresas/" + this.empresa.id, formData)
      .then((response) => {
        let datos = response.data;

        this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
        window.location.href = "/empresas";
      })
      .catch((error) => {
        if (error.response.status == 422) {
          this.errors = error.response.data.errors;
          console.log(this.errors);
        }
      });
    },
    imagene(e) {
      console.log(e.target.files[0]);
      let fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) => {
        this.imagen_empresa = e.target.result;
      };

      console.log(this.imagen_empresa);
    },
  },
};
</script>
<style lang="">
</style>