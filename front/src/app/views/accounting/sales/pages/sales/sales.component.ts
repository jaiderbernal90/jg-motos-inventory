import { Component, OnInit } from '@angular/core';
import { finalize } from 'rxjs/operators';
import { StatusService } from '../../../../inventory/products/services/status.service';
import { CrudServices } from '../../../../../shared/services/crud.service';
import { SalesModel } from '../../../../../shared/interfaces/sales';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-sales',
  templateUrl: './sales.component.html',
  styleUrls: ['./sales.component.scss']
})
export class SalesComponent implements OnInit {

  listSubscribers: Subscription[] = [];
  loading: boolean = false;
  limit: number = 10;
  orderColumn = [
      {
          title: 'ID',
          compare: (a: SalesModel, b: SalesModel) => a.id - b.id,
          priority: false
      },
      {
          title: 'Referencia',
      },
      {
          title: 'Cliente',
      },
      {
          title: 'Metodo pago',
      },
      {
        title: 'Fecha',
      },
      {
        title: 'Valor',
      },
      {
        title: 'Estado'
      },
      {
          title: ''
      }
  ]
  page: number = 1;
  searchInput: any;
  term: string = '';
  totalItems:number;
  salesList:SalesModel[];
  
  constructor( 
    private _crudSvc:CrudServices,
    private _statusSvc: StatusService,
  ){}

  ngOnInit(): void {
    this.listenObserver();
    this.getSales();
  }

  // ---------------------------------------------------------------------
  // ----------------------------GET DATA---------------------------------
  // ---------------------------------------------------------------------
  private getSales():void {
    this.loading = true;

    const query = [
      `?page=${this.page}`,
      `&term=${this.term}`,
      `&limit=${this.limit}`,
    ].join('');

    this._crudSvc.getRequest(`/sales/index${query}`).pipe(finalize( () => this.loading = false)).subscribe((res: any) => {
        const { data } = res;
        this.salesList = data.data;
        this.totalItems = data.total;
      })
  }
  // ---------------------------------------------------------------------
  // ------------------------PAGINATION AND FILTERS-----------------------
  // ---------------------------------------------------------------------
  public search(): void {
      this.term = this.searchInput;
      this.getSales()
  }

  public pageIndexChanged(page:number):void {
    this.page = page; 
    this.getSales();
  }

  public pageSizeChanged(limit: number):void {
      this.limit = limit; this.page = 1;
      this.getSales();
  }

  private listenObserver = () => {
    const observer1$ = this._crudSvc.requestEvent.subscribe((res) => {
      this.getSales();
    });

    this.listSubscribers = [observer1$];
  }
  
  ngOnDestroy(): void {
    this.listSubscribers.map(a => a.unsubscribe());
  }
  
}

