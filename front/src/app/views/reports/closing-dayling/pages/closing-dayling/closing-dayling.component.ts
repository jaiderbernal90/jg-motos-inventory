import { Component, OnInit } from '@angular/core';
import { CrudServices } from '../../../../../shared/services/crud.service';
import { ExpenseModel } from '../../../../../shared/interfaces/expense';
import { BailModel } from 'src/app/shared/interfaces/bail';
import { SalesModel } from '../../../../../shared/interfaces/sales';
import { finalize } from 'rxjs/operators';
import { getISOWeek } from 'date-fns';
import { DateServicesService } from '../../../../../shared/services/date-services.service';

@Component({
  selector: 'app-closing-dayling',
  templateUrl: './closing-dayling.component.html',
  styleUrls: ['./closing-dayling.component.scss']
})
export class ClosingDaylingComponent implements OnInit {
  date:Date = new Date();
  type:string = 'day';
  salesClosing:SalesModel | any;
  bailsClosing:BailModel | any;
  expensesClosing:ExpenseModel | any;
  isSpinning:boolean;

  constructor(
    private _crudSvc:CrudServices,
    private _dateSvc:DateServicesService 
  ) { }

  ngOnInit(): void {
    this.closingDayling(this._dateSvc.getDate(this.date, this.type));
  }

  private closingDayling(date:Date | number | string):void {
    this.isSpinning = true; 
    
    this._crudSvc.postRequest(`/reports/closingDayling`, { date, type: this.type })
    .pipe(finalize(() => this.isSpinning = false))
    .subscribe((res: any) => {
      const { data } = res;
      this.salesClosing = data?.sales;
      this.bailsClosing = data?.bails;
      this.expensesClosing = data?.expenses;
    })
  }

  public changeDate(event:any): void { 
    const { date, type } = event;
    this.type = type;
    this.closingDayling(this._dateSvc.getDate(date, type)); 
  }

}
