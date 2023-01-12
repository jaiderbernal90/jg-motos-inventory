import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { NotificationsService } from '../../../../../shared/services/notifications.service';
import { FilesService } from '../../../../../shared/services/file.service';
import { CrudServices } from '../../../../../shared/services/crud.service';
import { finalize } from 'rxjs/operators';
import { NzModalService } from 'ng-zorro-antd/modal';

@Component({
  selector: 'app-modal-import',
  templateUrl: './modal-import.component.html',
  styleUrls: ['./modal-import.component.scss']
})
export class ModalImportComponent implements OnInit {
  form:FormGroup;
  validExtensions: string[] = ['xls', 'xlsx'];
  file: File;

  constructor(
    private notification: NotificationsService,
    private formBuilder: FormBuilder,
    private filesService: FilesService,
    private _crudSvc:CrudServices,
    private modalService: NzModalService,
  ) { }

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      file:[null,[]],
      files:[null,[]],
    });
  }

  public submit(): void {
    this.filesService.loadProducts(this.file).subscribe(
      data => {
        return this.notification.success('Importe Exitoso', 'Los productos fueron importados exitosamente','top');        
      }, 
      error => {
          console.warn('ERROR => ', error);
          return this.notification.warning('Atención', 'Los productos no pudierón ser importados','top');  
      }
    );
  }

  uploadFile(event: any) {
    const [file] = event.target.files

    if (!file) return
    const { name } = file;
    const fileExtension = name.split('.').pop();

    if (!this.validExtensions.includes(fileExtension)) {
      return this.notification.warning('Extensión no válida', `Los formatos admitidos son ${this.validExtensions.join(', ')}`,'top');
    }
  
    this.file = file
  }
}
