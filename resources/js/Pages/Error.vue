<template>
  <div class="flex-center position-ref full-height">
           
            <div class="content">
                <div class="font-bold text-2xl m-b-md">
                    {{ title }}
                </div>

                <div>
                  {{ description }}
                </div>
                <div class="mt-8">
                
                  <a :href="route('dashboard')" class="rounded border-2 border-gray-600 text-white bg-gray-600 hover:bg-gray-500  relative p-3">
                      Regresar
                      <span class="absolute top-0 right-0 -mr-1 -mt-1 w-4 h-4 rounded-full bg-green-300 animate-ping"></span>
                      <span class="absolute top-0 right-0 -mr-1 -mt-1 w-4 h-4 rounded-full bg-green-300"></span>
                  </a>
                </div>
            </div>
        </div>
</template>

<script>
export default {
  props: {
    status: Number,
  },
  computed: {
    title() {
      return {
        503: '503: Servicio no disponible',
        500: '500: Error en el servidor',
        404: '404: Pagina no encontrada',
        403: '403: Prohibido',
      }[this.status]
    },
    description() {
      return {
        503: 'Lo siento, Estamos en mantenimiento. Intente luego.',
        500: 'Whoops, Algo salió mal.',
        404: 'Lo siento, La página que estas buscando no pudo ser encontrada.',
        403: 'Lo siento, No tiene permitido acceder a esta página.',
      }[this.status]
    },
  },
}
</script>
 <style>
  html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 200;
      height: 100vh;
      margin: 0;
  }

  .full-height {
      height: 100vh;
  }

  .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
  }

  .position-ref {
      position: relative;
  }

  .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
  }

  .content {
      text-align: center;
  }

  .title {
      font-size: 84px;
  }

  .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
  }

  .m-b-md {
      margin-bottom: 30px;
  }
</style>