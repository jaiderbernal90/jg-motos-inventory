import { Component, OnInit } from '@angular/core';
import { CrudServices } from '../../../../shared/services/crud.service';

@Component({
  selector: 'app-cards-info-reports',
  templateUrl: './cards-info-reports.component.html',
  styleUrls: ['./cards-info-reports.component.scss']
})
export class CardsInfoReportsComponent implements OnInit {
  totalSales:number = 0;
  totalSalesCount:number = 0;
  totalProductsCount:number = 0;
  totalProductsValue:number = 0;
  totalClientsCount:number = 0;
  totalUsersCount:number = 0;

  constructor( 
    private _crudSvc:CrudServices,
  ) {}

  ngOnInit(): void {
    this.getSalesTotal()
    this.getCountSales()
    this.getCountProducts()
    this.getValueProducts()
    this.getCountClients()
    this.getCountUsers()
  }

   private getSalesTotal():void {
      this._crudSvc.getRequest(`/dashboard/getSales`).subscribe((res: any) => {
          const { data } = res;
          this.totalSales = data;
      })
    } 
    
    private getCountSales():void {
        this._crudSvc.getRequest(`/dashboard/getCountSales`).subscribe((res: any) => {
            const { data } = res;
            this.totalSalesCount = data;
        })
    }

    private getCountProducts():void {
        this._crudSvc.getRequest(`/dashboard/getCountProducts`).subscribe((res: any) => {
            const { data } = res;
            this.totalProductsCount = data;
        })
    }

    private getValueProducts():void {
        this._crudSvc.getRequest(`/dashboard/getValueProducts`).subscribe((res: any) => {
            const { data } = res;
            this.totalProductsValue = data;
        })
    }

  private getCountClients():void {
    this._crudSvc.getRequest(`/dashboard/getCountClients`).subscribe((res: any) => {
        const { data } = res;
        this.totalClientsCount = data;
    })
  }

  private getCountUsers():void {
    this._crudSvc.getRequest(`/dashboard/getCountUsers`).subscribe((res: any) => {
        const { data } = res;
        this.totalUsersCount = data;
    })
  }
    
}
