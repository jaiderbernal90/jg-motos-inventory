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
  isSpinning:boolean = false;

  constructor(
    private notification: NotificationsService,
    private formBuilder: FormBuilder,
    private filesService: FilesService,
    private _crudSvc:CrudServices,
    private modalService: NzModalService,
  ) { }

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      file:[null,[Validators.required]],
    });
  }

  public submit(): void {
    this.isSpinning = true;
    this.filesService.loadProducts(this.file).pipe(finalize( () => {
        this.isSpinning = false;  
        this._crudSvc.requestEvent.emit('');
      }))
    .subscribe(
      data => {
        this.notification.success('Importe Exitoso', 'Los productos fueron importados exitosamente','top');       
        this.form.reset(); 
        return
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
      this.notification.warning('Extensión no válida', `Los formatos admitidos son ${this.validExtensions.join(', ')}`,'top');
      this.form.reset(); 
      return
    }
  
    this.file = file
  }
}
