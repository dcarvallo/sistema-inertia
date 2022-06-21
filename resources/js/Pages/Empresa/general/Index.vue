<template>
<app-layout>
  <div class="content bg-white p-3 rounded altura">
        <div class="flex my-2" v-if="$page.props.permisos.includes('Crear-empresas') || $page.props.permisos.includes('Editar-empresas')">
             
                <a v-if="empresa==null"  class="flex items-center p-2 text-white bg-blue-500 rounded select-none no-outline focus:shadow-outline" :href="route('empresas.create')">
                  <i class="far fa-plus-square"></i>
                  <span class="hidden md:block pl-2"> Crear</span>
                </a>
                <a v-else class="flex items-center p-2 bg-yellow-300 rounded select-none no-outline focus:shadow-outline" :href="route('empresas.edit', [empresa.id])">
                  <i class="far fa-plus-square"></i>
                  <span> <i class="pi pi-pencil"></i></span>
                  <span class="hidden md:block pl-2"> Editar</span>
                </a>
        </div>
            <div class="contentempresa grid grid-cols-1 md:grid-cols-2 mx-0 py-4">
                <div class="flex flex-col justify-center items-center">
                  <h1 class="mb-4" id="nombre">{{empresa.nombre}}</h1><br>
                  <p id="descripcion">{{empresa.descripcion}}</p>
                </div>
                
                <div v-if="empresa.imagen_empresa" class="flex justify-center my-3" >
                  <img :src="'/storage/'+ empresa.imagen_empresa" class="rounded img-fluid animate__animated animate__fadeIn animate__slower align-middle" style="max-height: 300px">
                </div>
            </div>
            <div class="my-3">
              <div>
              <div class="grid grid-cols-1 sm:grid-cols-2">
              <div class="p-2">
                <div>
                  <p class="mb-0"> {{empresa.rubro}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Rubro</p>
                </div>
                <br>
                <div>
                  <p class="mb-0"> {{empresa.nit}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">NIT</p>
                </div>
                <br>
                <div>
                  <p class="mb-0"> {{empresa.propietario}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">propietario</p>
                </div>
                <br>
                <div >
                  <p class="mb-0">{{empresa.mision}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Misión</p>
                </div>
                <br>
                <div >
                  <p class="mb-0">{{empresa.vision}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Visión</p>
                </div>
              </div>
              <div class="p-2">
                <div>
                  <p  class="mb-0">{{empresa.telefono}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Télefono</p>
                </div>
                <br>
                <div>
                  <p class="mb-0">Calle: {{empresa.direccion}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Dirección</p>
                </div>
                <br>
                <div>
                  <p class="mb-0">{{empresa.email}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Email</p>
                </div>
                <br>
                <div>
                  <p class="mb-0">{{empresa.fecha_creacion}}</p>
                  <hr class="my-0 border">
                  <p class="block tracking-wide text-grey-darker font-bold mb-2">Fecha de Creación</p>
                </div>
                
              </div>
              </div>
              </div>
            </div>

      </div>
      </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
export default { 
  props:['empresa'],
  components:{AppLayout}
  
}
</script>