import { Component, OnInit } from '@angular/core';
import { ThemeConstantService } from 'src/app/shared/services/theme-constant.service';
import { CrudServices } from '../../../../shared/services/crud.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {


    themeColors = this.colorConfig.get().colors;
    blue = this.themeColors.blue;
    blueLight = this.themeColors.blueLight;
    cyan = this.themeColors.cyan;
    cyanLight = this.themeColors.cyanLight;
    gold = this.themeColors.gold;
    purple = this.themeColors.purple;
    purpleLight = this.themeColors.purpleLight;
    red = this.themeColors.red;

    constructor( 
        private colorConfig:ThemeConstantService,
    ) {}

    ngOnInit(): void {}

    activityList = [
        {
            name: "Virgil Gonzales",
            avatar: this.blue,
            date: "10:44 PM",
            action: "Agrego un producto",
            target: "Prototype Design",
            actionType: "completed"
        },
        {
            name: "Lilian Stone",
            avatar: this.cyan,
            date: "8:34 PM",
            action: "Elimino un producto",
            target: "Mockup Zip",
            actionType: "upload"
        },
        {
            name: "Erin Gonzales",
            avatar: this.gold,
            date: "8:34 PM",
            action: "Agrego una categoría",
            target: "'This is not our work!'",
            actionType: "comment"
        },
        {
            name: "Riley Newman",
            avatar: this.blue,
            date: "8:34 PM",
            action: "Agrego una venta",
            target: "'Hi, please done this before tommorow'",
            actionType: "comment"
        },
        {
            name: "Pamela Wanda",
            avatar: this.red,
            date: "8:34 PM",
            action: "Edito una venta",
            target: "a file",
            actionType: "removed"
        },
    ]   
  

    
    
}
