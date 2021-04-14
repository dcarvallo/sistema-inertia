<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="bg-white altura rounded mx-auto py-2">
                <div class=" overflow-hidden sm:rounded-lg  grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3  xl:grid-cols-5 gap-7 p-2">
                   
                    <div v-if="this.$page.props.permisos.includes('Navegar-admin')" class='w-full border p-3 rounded shadow-lg'>
                      <div class="flex flex-row mb-6 mt-2">
                          <div class="mr-1 h-2 w-8 bg-blue-600 rounded-full cursor-pointer"></div>
                          <div class="mr-1 h-2 w-8 bg-red-600 rounded-full cursor-pointer"></div>
                          <div class="mr-1 h-2 w-8 bg-yellow-400 rounded-full cursor-pointer"></div>
                      </div>
                      <div class="flex flex-row">
                         <div class="flex flex-col mb-4 ml-4 mt-1">
                              <div class='text-gray-600 font-semibold'>Sistema de Administración</div>
                              <div class='text-gray-600 font-base text-sm'>Módulo</div>
                              <div class='text-gray-400 font-base text-sm italic'>"Modo admin"</div>
                          </div>
                      </div>
                      <div class='text-gray-400 font-medium text-sm border-2 border-gray-300 rounded-md cursor-pointer mb-6'><img class="rounded w-full h-48" src="img/Administracion.jpg"></div>
                      <div class="flex justify-start mb-4">
                          <div class="flex w-full justify-evenly mt-1">
                              <div class='font-medium text-xs'><span class="bg-red-400 px-2 py-1 text-center rounded text-gray-100 cursor-pointer"><i class="fas fa-tasks"></i> 0/4</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="far fa-comment-alt"></i> 2</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="fas fa-paperclip"></i> 1</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="far fa-bell"></i> 5</span></div>
                            </div>
                      </div>
                  </div>

                   <div v-if="this.$page.props.permisos.includes('Navegar-empresas')" class='w-full border p-3 rounded shadow-lg'>
                      <div class="flex flex-row mb-6 mt-2">
                          <div class="mr-1 h-2 w-8 bg-blue-600 rounded-full cursor-pointer"></div>
                          <div class="mr-1 h-2 w-8 bg-red-600 rounded-full cursor-pointer"></div>
                          <div class="mr-1 h-2 w-8 bg-yellow-400 rounded-full cursor-pointer"></div>
                      </div>
                      <div class="flex flex-row mb-4">
                         <div class="flex flex-col  ml-4 mt-1">
                              <div class='text-gray-600 font-semibold'>Estructura de la empresa</div>
                              <div class='text-gray-600 font-base text-sm'>Módulo</div>
                              <div class='text-gray-400 font-base text-sm italic'>"Partes empresa"</div>
                          </div>
                      </div>
                      <div class='text-gray-400 font-medium text-sm border-2 border-gray-300 rounded-md cursor-pointer mb-6'><img class="rounded w-full h-48" src="img/estructura.jpg"></div>
                      <div class="flex justify-start mb-4">
                          <div class="flex w-full justify-evenly mt-1">
                              <div class='font-medium text-xs'><span class="bg-red-400 px-2 py-1 text-center rounded text-gray-100 cursor-pointer"><i class="fas fa-tasks"></i> 0/4</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="far fa-comment-alt"></i> 2</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="fas fa-paperclip"></i> 1</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="far fa-bell"></i> 5</span></div>
                            </div>
                      </div>
                  </div>

                  <div class='w-full border p-3 rounded shadow-lg'>
                      <div class="flex flex-row mb-6 mt-2">
                          <div class="mr-1 h-2 w-8 bg-blue-600 rounded-full cursor-pointer"></div>
                          <div class="mr-1 h-2 w-8 bg-red-600 rounded-full cursor-pointer"></div>
                          <div class="mr-1 h-2 w-8 bg-yellow-400 rounded-full cursor-pointer"></div>
                      </div>
                      <div class="flex flex-row mb-4">
                         <div class="flex flex-col ml-4 mt-1">
                              <div class='text-gray-600 font-semibold'>Contactos</div>
                                <div class='text-gray-600 font-base text-sm'>Página</div>
                                <div class='text-gray-400 font-base text-sm italic'>"Datos personas"</div>
                          </div>
                      </div>
                      <div class='text-gray-400 font-medium text-sm border-2 border-gray-300 rounded-md cursor-pointer mb-6'><img class="rounded w-full h-48" src="img/contactos.png"></div>
                      <div class="flex justify-start mb-4">
                          <div class="flex w-full justify-evenly mt-1">
                              <div class='font-medium text-xs'><span class="bg-red-400 px-2 py-1 text-center rounded text-gray-100 cursor-pointer"><i class="fas fa-tasks"></i> 0/4</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="far fa-comment-alt"></i> 2</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="fas fa-paperclip"></i> 1</span></div>
                              <div class='font-medium text-xs'><span class="bg-gray-200 px-2 py-1 text-center rounded text-gray-400 cursor-pointer"><i class="far fa-bell"></i> 5</span></div>
                            </div>
                      </div>
                  </div>

                </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
