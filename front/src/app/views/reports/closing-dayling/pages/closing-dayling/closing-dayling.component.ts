import { Component, OnInit } from '@angular/core';
import { CrudServices } from '../../../../../shared/services/crud.service';

@Component({
  selector: 'app-closing-dayling',
  templateUrl: './closing-dayling.component.html',
  styleUrls: ['./closing-dayling.component.scss']
})
export class ClosingDaylingComponent implements OnInit {
  date:Date = new Date;
  salesClosing:any;
  bailsClosing:any;
  
  constructor(
    private _crudSvc:CrudServices 
    ) { }

  ngOnInit(): void {
    this.closingDayling();
  }

  private closingDayling():void {
    let dateFull = this.date ? this.date : new Date();
    let date = dateFull.getFullYear() + "-" + (dateFull.getMonth() + 1) + "-" + dateFull.getDate();
    
    let body = {
      'date': date
    };
    
    this._crudSvc.postRequest(`/reports/closingDayling/`, body)
      .subscribe((res: any) => {
        this.salesClosing = res['sales'];
        this.bailsClosing = res['bails'];
      })
  }

  public changeDate(){
    this.closingDayling();
  }

}
