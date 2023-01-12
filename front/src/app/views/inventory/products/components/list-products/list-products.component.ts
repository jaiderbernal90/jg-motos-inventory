import { Component, Input, OnInit } from '@angular/core';
import { ProductModel } from '../../../../../shared/interfaces/product';
import { CrudServices } from '../../../../../shared/services/crud.service';
import { NzMessageService } from 'ng-zorro-antd/message';

@Component({
  selector: 'app-list-products',
  templateUrl: './list-products.component.html',
  styleUrls: ['./list-products.component.scss']
})
export class ListProductsComponent implements OnInit {

  @Input() productsList:ProductModel[]; 
  @Input() orderColumn:any;
  @Input() loading:boolean;  

  constructor(
    private nzMessageService: NzMessageService,
    private _crudSvc:CrudServices,
  ) { }

  ngOnInit(): void {
  }

  cancel(): void {
    this.nzMessageService.info('Operacion cancelada');
  }

  confirm(id:number): void {

    this._crudSvc.deleteRequest(`/products/destroy/${id}`)
    .subscribe(res => {
      this._crudSvc.requestEvent.emit('deleted')
    })
  }

  beforeConfirm(): Promise<boolean> {
    return new Promise(resolve => {
      setTimeout(() => {
        resolve(true);
      }, 1000);
    });
  }

}
