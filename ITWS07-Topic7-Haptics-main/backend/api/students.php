<?php
// API endpoints for Student CRUD operations
require_once '../config/database.php';
require_once '../models/Student.php';

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // READ - Get all students or single student
        if(isset($_GET['id'])) {
            $student->id = $_GET['id'];
            if($student->readOne()) {
                $student_data = array(
                    "id" => $student->id,
                    "student_id" => $student->student_id,
                    "first_name" => $student->first_name,
                    "last_name" => $student->last_name,
                    "email" => $student->email,
                    "phone" => $student->phone,
                    "course" => $student->course,
                    "year_level" => $student->year_level
                );
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'data' => $student_data
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Student not found'
                ]);
            }
        } else {
            // Get all students
            $stmt = $student->read();
            $num = $stmt->rowCount();

            if($num > 0) {
                $students_arr = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $student_item = array(
                        "id" => $id,
                        "student_id" => $student_id,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "email" => $email,
                        "phone" => $phone,
                        "course" => $course,
                        "year_level" => $year_level
                    );
                    array_push($students_arr, $student_item);
                }
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'data' => $students_arr,
                    'count' => $num
                ]);
            } else {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'data' => [],
                    'count' => 0,
                    'message' => 'No students found'
                ]);
            }
        }
        break;

    case 'POST':
        // CREATE - Add new student
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->student_id) && !empty($data->first_name) && !empty($data->last_name)) {
            $student->student_id = $data->student_id;
            $student->first_name = $data->first_name;
            $student->last_name = $data->last_name;
            $student->email = $data->email;
            $student->phone = $data->phone ?? '';
            $student->course = $data->course ?? '';
            $student->year_level = $data->year_level ?? '';

            if($student->create()) {
                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'message' => 'Student was created successfully'
                ]);
            } else {
                http_response_code(503);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unable to create student'
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Unable to create student. Data is incomplete'
            ]);
        }
        break;

    case 'PUT':
        // UPDATE - Update student
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->id)) {
            $student->id = $data->id;
            $student->student_id = $data->student_id;
            $student->first_name = $data->first_name;
            $student->last_name = $data->last_name;
            $student->email = $data->email;
            $student->phone = $data->phone;
            $student->course = $data->course;
            $student->year_level = $data->year_level;

            if($student->update()) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Student was updated successfully'
                ]);
            } else {
                http_response_code(503);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unable to update student'
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Unable to update student. Data is incomplete'
            ]);
        }
        break;

    case 'DELETE':
        // DELETE - Delete student
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->id)) {
            $student->id = $data->id;

            if($student->delete()) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Student was deleted successfully'
                ]);
            } else {
                http_response_code(503);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unable to delete student'
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Unable to delete student. ID is required'
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        break;
}
?>

