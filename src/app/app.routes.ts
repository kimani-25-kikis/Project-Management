import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { Dashboard2Component } from './dashboard2/dashboard2.component';
import { ProjectsComponent } from './projects/projects.component';
import { EmployeesComponent } from './employees/employees.component';
import { LeavemanagementComponent } from './leavemanagement/leavemanagement.component';
import { HolidaysComponent } from './holidays/holidays.component';
import { AddprojectComponent } from './addproject/addproject.component';
import { ProjectdetailsComponent } from './projectdetails/projectdetails.component';
import { ProjectoverviewComponent } from './projectoverview/projectoverview.component';
import { SigninComponent } from './signin/signin.component';
import { SignupComponent } from './signup/signup.component';

export const appRoutes: Routes = [
  { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
  { path: 'dashboard', component: DashboardComponent },
  { path: 'dashboard2', component: Dashboard2Component },
  { path: 'projects', component: ProjectsComponent },
  { path: 'employees', component: EmployeesComponent },
  { path: 'leave', component: LeavemanagementComponent },
  { path: 'holidays', component: HolidaysComponent },
  { path: 'addproject', component: AddprojectComponent },
  { path: 'projectdetails', component: ProjectdetailsComponent },
  { path: 'projectoverview', component: ProjectoverviewComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'signin', component: SigninComponent },
  
];
