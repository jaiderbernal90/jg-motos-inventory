import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { DashboardRoutingModule } from './dashboard-routing.module';
import { DashboardComponent } from './pages/dashboard/dashboard.component';
import { SharedModule } from '../../shared/shared.module';
import { TranslateModule } from '@ngx-translate/core';
import { CardsInfoReportsComponent } from './components/cards-info-reports/cards-info-reports.component';
import { CardsTopProductsComponent } from './components/cards-top-products/cards-top-products.component';
import { CardsTopClientsComponent } from './components/cards-top-clients/cards-top-clients.component';
import { CardsRecentSalesComponent } from './components/cards-recent-sales/cards-recent-sales.component';
import { ChartsModule } from 'ng2-charts';
import { ComponentsModule } from 'src/app/shared/components.module';
import { CardRevenuesComponent } from './components/card-revenues/card-revenues.component';

@NgModule({
  declarations: [
    DashboardComponent,
    CardsInfoReportsComponent,
    CardsTopProductsComponent,
    CardsTopClientsComponent,
    CardsRecentSalesComponent,
    CardRevenuesComponent
  ],
  imports: [
    CommonModule,
    DashboardRoutingModule,
    SharedModule,
    TranslateModule,
    ChartsModule,
    ComponentsModule
  ]
})
export class DashboardModule { }
