###🏥 Medical Management System API
📋 Overview
Welcome to the Medical Management System API! This platform is designed to streamline healthcare communication between patients and doctors. It allows patients to submit medical queries, upload x-ray images, and access their health records, while doctors can provide expert responses, view patient medical histories, and analyze x-ray results. With robust user authentication and secure communication, this API is designed for an efficient healthcare experience. 🚀

###⚙️ Features
🩺 For Patients:
Submit Medical Queries: Patients can ask questions about symptoms and medical conditions. 📝

Upload X-Rays: Upload x-ray images for medical review by doctors. 📸

View Medical History: Patients can check their past medical treatments and surgeries. 📂

Authentication: Secure login/logout functionality to protect personal information. 🔒

👩‍⚕️ For Doctors:
Respond to Questions: Doctors can view patient queries and provide medical responses. 💬

View X-Rays: Doctors can analyze x-ray images uploaded by patients. 🖼️

Manage Medical Histories: Doctors can update patient medical records. 📋

Authentication: Secure login/logout for doctors. 🔑

👨‍💻 For Admins:
Manage Users: Admins can control both patient and doctor accounts. 👥

Manage Medical Records: Admins can access and manage the medical histories of patients. 🗃️

🛠️ Database Schema
1. Users Table 🧑‍⚕️👩‍⚕️
Stores user details (patients and doctors).

id: Primary Key

full_name: User's full name

email: User's email address

phone: User's contact number

usertype: Enum (patient, doctor)

password: Encrypted password

created_at: Timestamp when the account was created

updated_at: Timestamp when the account was last updated

2. Questions Table ❓
Stores medical queries submitted by patients.

id: Primary Key

patient_id: Foreign Key (User)

doctor_id: Foreign Key (User, Nullable)

question_text: Text of the patient's question

status: Enum (pending, answered)

created_at: Timestamp when the question was submitted

updated_at: Timestamp when the question was last updated

3. Responses Table 💬
Stores doctor responses to patient queries.

id: Primary Key

question_id: Foreign Key (Questions)

doctor_id: Foreign Key (Users)

response_text: Text of the doctor's response

created_at: Timestamp when the response was created

updated_at: Timestamp when the response was last updated

4. X-Rays Table 🩻
Stores x-ray images and their descriptions.

id: Primary Key

name_of_xray: Name of the x-ray type

description_of_xray: Description of the x-ray

result_of_xray: Interpretation of the x-ray results

type_of_xray: Type of the x-ray (e.g., chest, limb)

image_of_xray: Path to the stored x-ray image

user_id: Foreign Key (Users)

created_at: Timestamp when the x-ray was uploaded

updated_at: Timestamp when the x-ray was last updated

5. Medical Histories Table 🏥
Stores the medical histories of patients, including past surgeries.

id: Primary Key

name_of_surgery: Name of the surgery

description_of_surgery: Description of the surgery or treatment

user_id: Foreign Key (Users)

created_at: Timestamp when the history record was created

updated_at: Timestamp when the record was last updated

🖥️ API Endpoints
Authentication Endpoints 🔐
POST /api/login - Login a user and retrieve an authentication token.

POST /api/register - Register a new user (patient or doctor).

POST /api/logout - Logout the authenticated user.

GET /api/profile - Get authenticated user's profile details.

Patient Endpoints 🩺
POST /api/questions - Submit a medical question to a doctor.

GET /api/questions/{id} - View a specific question's details.

POST /api/xrays - Upload a new x-ray image.

GET /api/medical_histories_of_patient/{user_id} - Get the medical history for a patient.

Doctor Endpoints 👨‍⚕️
GET /api/questions/pending - View all pending patient queries.

POST /api/questions/{id}/response - Respond to a specific patient query.

GET /api/questions/{doctor_id}/{patient_id} - View all questions from a specific patient directed to a specific doctor.

GET /api/xrays/{user_id} - View x-ray images uploaded by a specific patient.

Admin Endpoints 👩‍💻
GET /api/medical_histories_of_patient/{user_id} - Get medical history records of a specific patient.

GET /api/unique_xray/{XRay_id} - View details of a specific x-ray by its ID.
