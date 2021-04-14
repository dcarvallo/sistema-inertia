<template>
  <app-layout>
      <div class="p-10">
        <FullCalendar :events="recordatorios" :options="options"/>
      <Dialog v-model:visible="display" :breakpoints="{'960px': '75vw'}" :style="{width: '50vw'}">
        <template #header>
          <h3>Recordatorio</h3>
        </template>

        <form >
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Titulo recordatorio*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.title" placeholder="Ejem. Reunion con gerente" autocomplete="false">
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.title" >{{$page.props.errors.title}}</span>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Descripcion recordatorio*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.descripcion" placeholder="Descripcion del recordatorio" autocomplete="false">
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.descripcion" >{{$page.props.errors.descripcion}}</span>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Fecha*</label>
            <Calendar v-model="form.fecha" />
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.fecha" >{{$page.props.errors.fecha}}</span>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Hora*</label>
            <input type="time" class="fappearance-none block bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.hora">
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.hora" >{{$page.props.errors.hora}}</span>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Duración*</label>
            <Dropdown v-model="form.duracion" :options="tiempos" optionLabel="nombre" optionValue="tiempo" placeholder="Selecciona la duración" />
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.duracion" >{{$page.props.errors.duracion}}</span>
          </div>

        <div >
          <Button @click="display=false" label="Cerrar" icon="pi pi-times" class="p-button-text"/>
              <Button @click.prevent="crearrecordatorio" type="submit" label="Guardar" icon="pi pi-check" />
        </div>
        </form>
      </Dialog>
      </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import moment from 'moment'

import FullCalendar from 'primevue/fullcalendar';
import '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import esLocale from '@fullcalendar/core/locales/es';
  export default {
    components: {
      AppLayout,
      FullCalendar,
      Dialog,
      Dropdown,
      Calendar,
      Button
    },
    props: [
      'recordatorios'
    ],
    data() {
      return {
        display: false,
        form: this.$inertia.form({
          title: '',
          descripcion: '',
          fecha: null,
          hora: null,
          duracion: '900',
        }),
        tiempos: [
          {nombre: '15 Minutos', tiempo: '900'},
          {nombre: 'Media hora', tiempo: '1800'},
          {nombre: '1 hora', tiempo: '3600'},
          {nombre: '2 horas', tiempo: '7200'},
          {nombre: '3 horas', tiempo: '10800'},
          {nombre: '4 horas', tiempo: '14400'},
          {nombre: '5 horas', tiempo: '18000'},
          {nombre: '6 horas', tiempo: '21600'},
          {nombre: '1 día', tiempo: '86400'},
        ],
        options: {
          plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
          // initialDate: "2020-12-01",
          // initialView: 'timeGridWeek' ,
          locale: esLocale,
          headerToolbar: {
            left: "prev,next",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
          },
          height: 'auto',
          dateClick: this.handleDateClick,
          editable: true,
        },
      };
    },
    methods:{
      crearrecordatorio()
      {
        let formData = new FormData();
        formData.append('title', this.form.title);
        formData.append('descripcion', this.form.descripcion);
        formData.append('duracion', this.form.duracion);
        if(this.form.fecha && this.form.hora){
          let fechacopmleta = this.form.fecha +' '+ this.form.hora;

          let nueva = new Date(fechacopmleta);
          let getSeconds = nueva.getSeconds() + this.form.duracion

          nueva.setSeconds(getSeconds)

          let convertido = moment(nueva)

          formData.append('start', fechacopmleta);
          formData.append('end', convertido.format('YYYY-MM-DD HH:mm:ss'));
          
        }
        this.$inertia.post('/recordatorio/store', formData, {
          onSuccess : () => {
            this.form.reset()
            if(this.$page.props.flash.mensaje){
              let datos = this.$page.props.flash.mensaje
              this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
            }
            this.display = false
          },
        })
      },
      handleDateClick(infoClick){
        this.display = true
        const dateandtime = infoClick.dateStr.split("T")
        this.form.fecha = dateandtime[0]
        if(dateandtime[1])
        this.form.hora = dateandtime[1].substr(0, 8)
      }
    }
  }
</script>