<template>
  <app-layout>
    <div class="bg-white md:flex pb-16">
      <div class="p-2 w-full md:w-1/4">

        <div class="">
            <div class="flex justify-center">
              <img class="w-64 rounded-full "
                    :src="'storage/'+$page.props.user.fotografia"
                    alt="imagen de usuario">
            </div>

            <h3 class="profile-username text-center">{{$page.props.user.name}}</h3>

            <p class="text-muted text-center">Cargo: Software Engineer</p>

            <a class="select-none block bg-blue-600 text-white p-2 my-2 rounded text-center" :href="route('cambiar.password')">
              Cambiar contraseña
            </a>
        </div>
        <h3 class="text-xl">Acerca de</h3>
        <hr class=" border-2 border-gray-800">
        <div class="flex flex-col ">
          <div>

          <h4 class="text-xl font-bold my-2"><i class="fas fa-book mr-1"></i> Educación</h4>

          <p class="my-1">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, perferendis.
          </p>
          </div>

          <hr class="border-2">
          <div>

            <h4 class="text-xl font-bold my-2"><i class="fas fa-pencil-alt mr-1"></i> Habilidades</h4>

            <div class="my-1">
              <p class="tag tag-danger">UI Design</p>
              <p class="tag tag-success">Coding</p>
              <p class="tag tag-info">Javascript</p>
              <p class="tag tag-warning">PHP</p>
              <p class="tag tag-primary">Node.js</p>
            </div>
          </div>

          <hr class="border-2">
          <div class="gap-4">

          <h4 class="text-xl font-bold my-2"><i class="far fa-file-alt mr-1"></i> Notas</h4>

          <p class="my-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
          </div>
        </div>
      </div>
      <div class="p-2 w-full border-l border-gray-300 rounded md:w-3/4">
      
        <TabView class="p-4 bg-white ">
          <TabPanel header='Home'>
             <div class="p-2">
                      <div class="flex justify-between">
                        <div class="flex items-center">
                          <img class="rounded-full inline-block w-10 align-middle mr-3" src="img/user1-128x128.jpg" alt="user image">
                          <span class="inline-block">
                            <p href="#">Jonathan Burke Jr.</p>
                            <p class="description">Shared publicly - 7:30 PM hoy</p>
                          </span>
                        </div>
                          <a href="#" class=" inline-block float-right "><i class="fas fa-times"></i></a>
                      </div>
                      
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p class="my-2">
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Compartir</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comentarios (5)
                          </a>
                        </span>
                      </p>
                      <div class="flex my-2">
                        <input class="w-full" type="text" placeholder="Escribe un comentario">
                        <button class="bg-blue-600 text-white p-2 rounded">Enviar</button>
                      </div>

                    </div>
                    
                    <div class="p-2">
                      <div class="flex justify-between">
                        <div class="flex items-center">
                          <img class="rounded-full inline-block w-10 align-middle mr-3" src="img/user7-128x128.jpg" alt="User Image">
                          <span class="inline-block">
                            <p href="#">Sarah Ross</p>
                            <span class="description">Sent you a message - Hace 3 dias</span>
                          </span>
                        </div>
                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                      </div>
                      
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                        <div class="flex my-2">
                        <input class="w-full" type="text" placeholder="Escribir un comentario">
                        <button class="bg-blue-600 text-white p-2 rounded">Enviar</button>
                      </div>
                        </div>
                      </form>
                    </div>
                    
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Posted 5 photos - Hace 5 dias</span>
                      </div>
                      
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="w-64" src="img/photo1.png" alt="Photo">
                        </div>
                        
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="w-64 mb-3" src="img/photo2.png" alt="Photo">
                              <img class="w-64" src="img/photo3.jpg" alt="Photo">
                            </div>
                            
                            <div class="col-sm-6">
                              <img class="w-64 mb-3" src="img/photo4.jpg" alt="Photo">
                              <img class="w-64" src="img/photo1.png" alt="Photo">
                            </div>
                            
                          </div>
                          
                        </div>
                      </div>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Compartir</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comentarios (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
          </TabPanel>
          <TabPanel header='Settings'>
             <div class="p-2 timeline timeline-inverse">
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Leer mas</a>
                            <a href="#" class="btn btn-danger btn-sm">Borrar</a>
                          </div>
                        </div>
                      </div>
                      
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>

                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
          </TabPanel>
          <TabPanel header='Linea de tiempo'>
              
              
          </TabPanel>
        </TabView>
              
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';


import FullCalendar from 'primevue/fullcalendar';
import '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

  export default {
    components: {
      AppLayout,
      TabView,
      TabPanel,
      FullCalendar
    },
    data() {
      return {
        options: {
          plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
          initialDate: "2020-12-01",
          headerToolbar: {
            left: "prev,next",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
          },
          editable: true,
        },
        events: [
          {
            id: 1,
            title: "All Day Event",
            start: "2020-12-01",
          },
          {
            id: 2,
            title: "Long Event",
            start: "2020-12-07",
            end: "2020-12-10",
          },
        ],
      };
    },
  }
</script>
<style >

/* .p-highlight{
  border-left: 1px solid blue;
  border-right: 1px solid blue;
} */
</style>