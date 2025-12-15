import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import {
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonButton,
  IonButtons,
  IonIcon,
  IonInput,
  IonSelect,
  IonSelectOption,
  IonItem,
  IonLabel,
  IonModal,
  IonList,
  IonGrid,
  IonRow,
  IonCol,
  IonText,
  IonChip,
  ToastController,
  AlertController
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { addOutline, createOutline, trashOutline, searchOutline, personAddOutline } from 'ionicons/icons';
import { StudentService, Student } from '../services/student.service';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    HttpClientModule,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonButton,
    IonButtons,
    IonIcon,
    IonInput,
    IonSelect,
    IonSelectOption,
    IonItem,
    IonLabel,
    IonModal,
    IonList,
    IonGrid,
    IonRow,
    IonCol,
    IonText,
    IonChip,
  ],
  providers: [StudentService]
})
export class HomePage implements OnInit {
  students: Student[] = [];
  filteredStudents: Student[] = [];
  selectedStudent: Student | null = null;
  isModalOpen = false;
  isEditMode = false;

  // Form data
  studentForm: Student = {
    student_id: '',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    course: '',
    year_level: ''
  };

  courses = [
    'Computer Science',
    'Information Technology',
    'Computer Engineering',
    'Information Systems',
    'Software Engineering',
    'Business Administration',
  ];

  yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year'];

  constructor(
    private studentService: StudentService,
    private toastController: ToastController,
    private alertController: AlertController
  ) {
    addIcons({ addOutline, createOutline, trashOutline, searchOutline, personAddOutline });
  }

  ngOnInit() {
    this.loadStudents();
  }

  // Load all students
  loadStudents() {
    this.studentService.getAllStudents().subscribe({
      next: (response) => {
        if (response.success) {
          this.students = response.data;
          this.filteredStudents = this.students;
          console.log('Students loaded:', this.students);
        }
      },
      error: (error) => {
        console.error('Error loading students:', error);
        this.presentToast('Error loading students. Make sure XAMPP is running!', 'danger');
      }
    });
  }

  // Open modal for adding student
  openAddModal() {
    this.isEditMode = false;
    this.resetForm();
    this.isModalOpen = true;
  }

  // Open modal for editing student
  openEditModal(student: Student) {
    this.isEditMode = true;
    this.studentForm = { ...student };
    this.isModalOpen = true;
  }

  // Close modal
  closeModal() {
    this.isModalOpen = false;
    this.resetForm();
  }

  // Reset form
  resetForm() {
    this.studentForm = {
      student_id: '',
      first_name: '',
      last_name: '',
      email: '',
      phone: '',
      course: '',
      year_level: ''
    };
  }

  // Save student (Create or Update)
  saveStudent() {
    if (this.isEditMode) {
      this.updateStudent();
    } else {
      this.createStudent();
    }
  }

  // CREATE - Add new student
  createStudent() {
    this.studentService.createStudent(this.studentForm).subscribe({
      next: (response) => {
        if (response.success) {
          this.presentToast('Student added successfully!', 'success');
          this.loadStudents();
          this.closeModal();
        }
      },
      error: (error) => {
        console.error('Error creating student:', error);
        this.presentToast('Error adding student', 'danger');
      }
    });
  }

  // UPDATE - Update student
  updateStudent() {
    this.studentService.updateStudent(this.studentForm).subscribe({
      next: (response) => {
        if (response.success) {
          this.presentToast('Student updated successfully!', 'success');
          this.loadStudents();
          this.closeModal();
        }
      },
      error: (error) => {
        console.error('Error updating student:', error);
        this.presentToast('Error updating student', 'danger');
      }
    });
  }

  // DELETE - Delete student
  async deleteStudent(student: Student) {
    const alert = await this.alertController.create({
      header: 'Confirm Delete',
      message: `Are you sure you want to delete ${student.first_name} ${student.last_name}?`,
      buttons: [
        {
          text: 'Cancel',
          role: 'cancel'
        },
        {
          text: 'Delete',
          role: 'destructive',
          handler: () => {
            this.studentService.deleteStudent(student.id!).subscribe({
              next: (response) => {
                if (response.success) {
                  this.presentToast('Student deleted successfully!', 'success');
                  this.loadStudents();
                }
              },
              error: (error) => {
                console.error('Error deleting student:', error);
                this.presentToast('Error deleting student', 'danger');
              }
            });
          }
        }
      ]
    });

    await alert.present();
  }

  // Show toast message
  async presentToast(message: string, color: string) {
    const toast = await this.toastController.create({
      message: message,
      duration: 2000,
      color: color,
      position: 'top'
    });
    toast.present();
  }
}
