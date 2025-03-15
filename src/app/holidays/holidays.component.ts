import { Component } from '@angular/core';
import { MatIconModule } from '@angular/material/icon';
import { RouterModule } from '@angular/router'; 

@Component({
  selector: 'app-holidays',
  imports: [MatIconModule, RouterModule],
  templateUrl: './holidays.component.html',
  styleUrl: './holidays.component.css'
})
export class HolidaysComponent {

}
