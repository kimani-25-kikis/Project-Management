import { Component } from '@angular/core';
import { MatIconModule } from '@angular/material/icon';
import { RouterModule } from '@angular/router';
import { HttpClient } from '@angular/common/http';
@Component({
  selector: 'app-signup',
  imports: [MatIconModule, RouterModule],
  templateUrl: './signup.component.html',
  styleUrl: './signup.component.css'
})
export class SignupComponent {
  constructor(private http: HttpClient) {}

  registerUser(event: Event) {
    event.preventDefault();
    
    const form = event.target as HTMLFormElement;
    const formData = new FormData(form);

    const user = {
      username: formData.get("username"),
      email: formData.get("email"),
      role: formData.get("role"),
      password: formData.get("password")
    };

    this.http.post('http://localhost/php-backend/auth/register.php', user)
      .subscribe(response => {
        console.log('User registered successfully', response);
        alert("Registration Successful!");
      }, error => {
        console.error('Error:', error);
        alert("Registration Failed!");
      });
  }
}
