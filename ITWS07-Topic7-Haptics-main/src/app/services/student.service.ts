import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Student {
  id?: number;
  student_id: string;
  first_name: string;
  last_name: string;
  email: string;
  phone?: string;
  course?: string;
  year_level?: string;
}

@Injectable({
  providedIn: 'root'
})
export class StudentService {
  // Update this URL to match your XAMPP setup
  // If running on same machine: http://localhost/your-project-folder/backend/api/students.php
  private apiUrl = 'http://localhost/student-management/backend/api/students.php';

  private httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  };

  constructor(private http: HttpClient) { }

  // CREATE - Add new student
  createStudent(student: Student): Observable<any> {
    return this.http.post<any>(this.apiUrl, JSON.stringify(student), this.httpOptions);
  }

  // READ - Get all students
  getAllStudents(): Observable<any> {
    return this.http.get<any>(this.apiUrl);
  }

  // READ ONE - Get single student
  getStudent(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}?id=${id}`);
  }

  // UPDATE - Update student
  updateStudent(student: Student): Observable<any> {
    return this.http.put<any>(this.apiUrl, JSON.stringify(student), this.httpOptions);
  }

  // DELETE - Delete student
  deleteStudent(id: number): Observable<any> {
    return this.http.delete<any>(this.apiUrl, {
      ...this.httpOptions,
      body: JSON.stringify({ id: id })
    });
  }
}

