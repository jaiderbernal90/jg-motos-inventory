import { Component, OnInit } from '@angular/core';
import { CrudServices } from '../../../../shared/services/crud.service';

@Component({
  selector: 'app-cards-top-products',
  templateUrl: './cards-top-products.component.html',
  styleUrls: ['./cards-top-products.component.scss']
})
export class CardsTopProductsComponent implements OnInit {
 
  productsList = [
      // {
      //     name: 'Gray Sofa',
      //     avatar: 'assets/images/others/thumb-9.jpg',
      //     category: 'Home Decoration',
      //     growth: 18.3
      // },
      // {
      //     name: 'Beat Headphone',
      //     avatar: 'assets/images/others/thumb-10.jpg',
      //     category: 'Eletronic',
      //     growth: 12.7
      // },
      // {
      //     name: 'Wooden Rhino',
      //     avatar: 'assets/images/others/thumb-11.jpg',
      //     category: 'Home Decoration',
      //     growth: 9.2
      // },
      // {
      //     name: 'Red Chair',
      //     avatar: 'assets/images/others/thumb-12.jpg',
      //     category: 'Home Decoration',
      //     growth: 7.7
      // },
      // {
      //     name: 'Wristband',
      //     avatar: 'assets/images/others/thumb-13.jpg',
      //     category: 'Eletronic',
      //     growth: 5.8
      // }
  ]    
   
  constructor(
    private _crudSvc:CrudServices,
  ) { }

  ngOnInit():void {
    this.getTopProducts()
  }

  private getTopProducts():void {
      this._crudSvc.getRequest(`/dashboard/getTopProducts`).subscribe((res: any) => {
          const { data } = res;
          this.productsList = data.data;
      })
  }
}
