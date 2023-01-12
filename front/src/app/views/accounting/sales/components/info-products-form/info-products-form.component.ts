import { Component, Input, OnInit } from '@angular/core';
import { UntypedFormBuilder, UntypedFormGroup, Validators, UntypedFormArray } from '@angular/forms';
import { finalize, filter } from 'rxjs/operators';
import { NotificationsService } from 'src/app/shared/services/notifications.service';
import { CrudServices } from '../../../../../shared/services/crud.service';
import { ProductsDetailService } from '../../services/products-detail.service';
import { ValidationsForm } from '../../validations/validations-form';
import { ProductModel } from '../../../../../shared/interfaces/product';

@Component({
  selector: 'app-info-products-form',
  templateUrl: './info-products-form.component.html',
  styleUrls: ['./info-products-form.component.scss']
})
export class InfoProductsFormComponent implements OnInit {
  
  @Input() form:UntypedFormGroup;
  @Input() products:UntypedFormArray;
  
  formProduct:UntypedFormGroup;
  loading:boolean; 
  
  constructor(
    private fb: UntypedFormBuilder,
    private _crudSvc:CrudServices,
    private _notificationSvC:NotificationsService,
    private _productDetailSvC:ProductsDetailService
  ) { }

  ngOnInit(): void {
    this.formProduct = this.fb.group({
        id: [ null, [ ] ],
        reference: [ null, [ Validators.required ] ],
        name:[null, [  ]],
        stock:[null, [  ]],
        amount:[null, [ Validators.required ]],
        price:[null, [ Validators.required ]],
    },
    {
      validator: ValidationsForm.match('stock', 'amount', 'no-same')
    });
  }

  public submit(): void {

    if(!this.validateExists()) {
      this.addProductsForm(this.formProduct.value)
      this._productDetailSvC.setChangePrice$(true)
      this.formProduct.reset()
      return
    }
    
    this._notificationSvC.info('Atención','Ya se ha agregado ese producto','top');
  }

  private addProductsForm(product: ProductModel):void {          
      const lessonForm = this.fb.group({
        product_id: [product?.id],
        reference: [product?.reference],
        name: [product.name],
        amount: [product?.amount],
        stock: [product?.stock],
        price:[product?.price],
        subtotal:[product?.amount * product?.price],
      },   
      {
        validator: ValidationsForm.match('stock', 'amount', 'no-same')
      });      
      this.products.push(lessonForm);  
  }

  //------------------------------------------------------------------------
  //-------------------------------EVENTS-----------------------------------
  //------------------------------------------------------------------------
  public onChangeReference(event){
    this.resetFields()
    if(!event) return

    let reference = this.formProduct.get('reference').value;

     this._crudSvc.getRequest(`/products/getForReference/${reference}`).subscribe((res: any) => {
      const { success,data } = res;
      if(success){ 
        this.formProduct.patchValue(data)       
      } 
    })
  }

  public onChangeAmount(amount:number){
    let stock = this.formProduct.get('stock').value;
    if(amount > stock) this._notificationSvC.info('Atención','No hay suficientes unidades disponibles','top');
  }

  //------------------------------------------------------------------------
  //------------------------AUXILIAR FUNCTIONS------------------------------
  //------------------------------------------------------------------------
  
  private resetFields() {
    this.formProduct.patchValue({ name:null,stock:null,amount:null, price:null })
  }

  private validateExists = () => (this.products.value.filter(e => e.id == this.formProduct.get('id').value)).length;
  
}

