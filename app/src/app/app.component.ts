import { Component } from '@angular/core';
import { ServicesService } from './apis/services.service';
import Swal from 'sweetalert2';
declare var bootstrap: any; // Declaración para evitar errores en TypeScript

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent {
  title = 'app';
  contactos: any;
  contact = {
    cts_id: '',
    cts_nombre: '',
    cts_pagina_web: '',
    cts_empresa: '',
    cts_notas: '',
  };
  datos = {
    tls_telefono: '',
    eml_email: '',
    dir_direccion: '',
    id_contacto: '',
  };
  nombre: string = '';
  empresa: string = '';
  pagina: string = '';
  notas: string = '';
  telefonos: string = '';
  emails: string = '';
  direcciones: string = '';

  formErrors: { [key: string]: string } = {}; // Objeto para almacenar mensajes de error
  errorMessage: string = '';

  searchTerm: string = '';

  constructor(private apiService: ServicesService) {}

  ngOnInit() {
    this.mostrarContactos();
  }

  mostrarContactos() {
    this.apiService.getContactos().subscribe(
      (data) => {
        this.contactos = data.contactos;
      },
      (error) => {
        console.error('Error occurred:', error);
      }
    );
  }

  agregarContacto(): void {
    this.formErrors = {};
    this.errorMessage = '';
    this.contact = {
      cts_id: '',
      cts_nombre: '',
      cts_empresa: '',
      cts_pagina_web: '',
      cts_notas: '',
    };
    const modalElement = document.getElementById('agregarContacto');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
  }
  agregarDatos(id_contacto: any): void {
    this.formErrors = {};
    this.errorMessage = '';
    this.datos = {
      tls_telefono: '',
      eml_email: '',
      dir_direccion: '',
      id_contacto: id_contacto,
    };
    const modalElement = document.getElementById('agregarDatos');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
  }

  guardarContacto(): void {
    this.apiService.createContactForm(this.contact).subscribe({
      next: (response) => {
        if (response.status) {
          Swal.fire({
            title: '¡Muy bien!',
            text: response.mensaje,
            icon: 'success',
            focusConfirm: true,
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              this.mostrarContactos();
              this.formErrors = {};
              this.errorMessage = '';

              const modalElement = document.getElementById('agregarContacto');
              const modal = bootstrap.Modal.getInstance(modalElement);
              if (modal) {
                modal.hide();
              }
              this.contact = {
                cts_id: '',
                cts_nombre: '',
                cts_empresa: '',
                cts_pagina_web: '',
                cts_notas: '',
              };
            } else if (result.dismiss) {
              window.location.reload();
            }
          });
        } else {
          this.errorMessage = response.mensaje || 'Ocurrió un error.';
          this.formErrors = this.formatErrors(response.errores);
        }
      },
      error: (error) => {
        console.error('Error al enviar el formulario:', error);
      },
    });
  }

  guardarDatos(): void {
    this.apiService.createDatosForm(this.datos).subscribe({
      next: (response) => {
        if (response.status) {
          Swal.fire({
            title: '¡Muy bien!',
            text: response.mensaje,
            icon: 'success',
            focusConfirm: true,
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              this.mostrarContactos();
              this.formErrors = {};
              this.errorMessage = '';

              const modalElement = document.getElementById('agregarDatos');
              const modal = bootstrap.Modal.getInstance(modalElement);
              if (modal) {
                modal.hide();
              }
              this.datos = {
                tls_telefono: '',
                eml_email: '',
                dir_direccion: '',
                id_contacto: '',

              };
            } else if (result.dismiss) {
              window.location.reload();
            }
          });
        } else {
          this.errorMessage = response.mensaje || 'Ocurrió un error.';
          this.formErrors = this.formatErrors(response.errores);
        }
      },
      error: (error) => {
        console.error('Error al enviar el formulario:', error);
      },
    });
  }

  formatErrors(errors: { [key: string]: string[] }): { [key: string]: string } {
    const formattedErrors: { [key: string]: string } = {};
    for (const [field, messages] of Object.entries(errors)) {
      formattedErrors[field] = messages.join(' ');
    }
    return formattedErrors;
  }

  editarcontacto(cts_id: number): void {
    this.apiService.getContactById(cts_id).subscribe({
      next: (data) => {
        // Asigna los datos del contacto al formulario
        this.contact = {
          cts_id: data.contactos.cts_id,
          cts_nombre: data.contactos.cts_nombre,
          cts_empresa: data.contactos.cts_empresa,
          cts_pagina_web: data.contactos.cts_pagina_web,
          cts_notas: data.contactos.cts_notas,
        };
        const modalElement = document.getElementById('agregarContacto');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
      },
      error: (error) => {
        console.error('Error al cargar el contacto:', error);
        this.errorMessage = 'Error al cargar el contacto.';
      },
    });
  }
  verContacto(cts_id: number): void {
    this.apiService.getContactById(cts_id).subscribe({
      next: (data) => {
        this.nombre = data.contactos.cts_nombre;
        this.empresa = data.contactos.cts_empresa;
        this.pagina = data.contactos.cts_pagina_web;
        this.notas = data.contactos.cts_notas;

        this.telefonos = data.telefonos;
        this.emails = data.emails;
        this.direcciones = data.direcciones;

        const modalElement = document.getElementById('verContacto');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
      },
      error: (error) => {
        console.error('Error al cargar el contacto:', error);
        this.errorMessage = 'Error al cargar el contacto.';
      },
    });
  }
  eliminarContacto(cts_id: number): void {
    var datos = { cts_id: cts_id };
    Swal.fire({
      title: '¡Advertencia!',
      text: '¿Esta seguro de eliminar el contacto?',
      icon: 'warning',
      focusConfirm: true,
      confirmButtonText: 'Si, eliminar',
    }).then((result) => {
      if (result.isConfirmed) {
        this.apiService.deleteContact(datos).subscribe({
          next: (data) => {
            this.mostrarContactos();
          },
          error: (error) => {
            console.error('Error al cargar el contacto:', error);
            this.errorMessage = 'Error al cargar el contacto.';
          },
        });
      } else if (result.dismiss) {
      }
    });
  }

  buscarContactos(event: Event): void {
    const input = event.target as HTMLInputElement;
    this.searchTerm = input.value;
    if (this.searchTerm.length >= 2) {
      this.apiService.buscarContactos(this.searchTerm).subscribe({
        next: (data) => {
          this.contactos = data;
        },
        error: (err) => {
          console.error('Error al buscar:', err);
        },
      });
    } else {
      this.mostrarContactos();
    }
  }
}
