import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { FormsModule } from '@angular/forms';
import { HttpClientJsonpModule, HttpClientModule } from '@angular/common/http';
import { RouterModule } from "@angular/router";
import { NzIconModule } from 'ng-zorro-antd/icon';
import { NzToolTipModule } from 'ng-zorro-antd/tooltip';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';
import { ThemeConstantService } from './services/theme-constant.service';
import { SearchPipe } from './pipes/search.pipe';
import { LoadingButtonDirective } from './directives/loading-button.directive';
import { GobalTableComponent } from './components/gobal-table/gobal-table.component';
import { NzTableModule } from 'ng-zorro-antd/table';
import { ObjToArrayPipe } from './pipes/obj-to-array.pipe';
import { StatusProductPipe } from './pipes/status-product.pipe';
import { ColorProductPipe } from './pipes/color-product.pipe';
import { CategoriesNavComponent } from './components/categories-nav/categories-nav.component';
import { NzTabsModule } from 'ng-zorro-antd/tabs';
import { TranslateModule } from '@ngx-translate/core';
import { StatusSalePipe } from './pipes/status-sale.pipe';
import { ExportButtonComponent } from './components/export-button/export-button.component';
import { NzButtonModule } from 'ng-zorro-antd/button';

const LIST_MODULES = [
    SearchPipe,
    LoadingButtonDirective,
    ObjToArrayPipe,
    StatusProductPipe,
    ColorProductPipe,
    StatusSalePipe
]

@NgModule({
    exports: [
        CommonModule,
        FormsModule,
        HttpClientModule,
        HttpClientJsonpModule,
        NzIconModule,
        PerfectScrollbarModule,
        GobalTableComponent,
        CategoriesNavComponent,
        ExportButtonComponent,
        ...LIST_MODULES
    ],
    imports: [
        RouterModule,
        CommonModule,
        NzIconModule,
        NzToolTipModule,
        PerfectScrollbarModule,
        NzTableModule,
        TranslateModule,
        NzTabsModule,
        NzButtonModule
    ],
    declarations: [
        ...LIST_MODULES,
        GobalTableComponent,
        CategoriesNavComponent,
        StatusSalePipe,
        ExportButtonComponent,
    ],
    providers: [
        ThemeConstantService
    ]
})

export class SharedModule { }