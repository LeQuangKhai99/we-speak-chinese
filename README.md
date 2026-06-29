# We Speak Chinese - Hệ thống Học Tiếng Trung Toàn Diện

**We Speak Chinese** là một nền tảng web học tập từ vựng, ngữ pháp và luyện nghe tiếng Trung trực quan và tương tác cao. Hệ thống được xây dựng trên mô hình kiến trúc hiện đại nhất hiện nay, kết hợp thế mạnh của **Laravel API** và **Vue 3 SPA**.

---

## 🛠️ Công Nghệ Sử Dụng

1.  **Frontend**:
    *   **Vue 3** (Composition API, Script Setup).
    *   **Vite** (Bộ đóng gói siêu tốc).
    *   **Tailwind CSS v4** (Thiết kế CSS-first hiện đại, mượt mà).
    *   **Pinia & Vue Router** (Quản lý trạng thái và điều hướng trang).
    *   **SpeechSynthesis API** (Phát âm giọng đọc AI chuẩn Trung phổ thông).
2.  **Backend & Database**:
    *   **Laravel 10** (API Server chuyên biệt).
    *   **Laravel Sanctum** (Xác thực API bằng Tokens an toàn).
    *   **SQLite** (Cơ sở dữ liệu nhẹ, dễ triển khai cục bộ).
    *   **Repository Pattern & DTOs** (Cấu trúc code bền vững, dễ mở rộng).

---

## ✨ Các Tính Năng Nổi Bật

### 1. Học Từ Vựng Flashcard Tương Tác
*   Học từ vựng HSK qua các thẻ từ lật mở 2 mặt sinh động (chữ Hán, Phiên âm Pinyin, Nghĩa tiếng Việt, và câu ví dụ).
*   **Adaptive TTS**: Mặt trước đọc từ đơn, mặt sau tự động đọc toàn bộ câu ví dụ đi kèm giúp luyện phản xạ ngữ cảnh.

### 2. Thi Nghe Tả Tranh HSK (HSK Listening Exam)
*   Mô phỏng chân thực phần thi nghe tả tranh HSK Part 1 / TOEIC Part 1.
*   Trình phát âm thanh có **thanh tiến trình chạy tự động (Progress Timeline)**.
*   Hệ thống chấm điểm Đúng/Sai trực tiếp, hiển thị hộp thoại đáp án có dịch nghĩa tiếng Việt chi tiết kèm nút phát âm riêng lẻ.

### 3. Phòng Luyện Mẫu Câu Giao Tiếp
*   Tổng hợp các mẫu câu giao tiếp hàng ngày chia theo các chủ đề: *Chào hỏi, Cảm ơn & Xin lỗi, Mua sắm & Ăn uống, Giao tiếp thực tế*.
*   Học viên có thể nghe phát âm của từng câu nói riêng biệt để luyện ngữ điệu.

### 4. Thư Viện Video Bài Giảng
*   Lọc video bài giảng YouTube theo cấp độ (Sơ cấp, Trung cấp, Cao cấp) và chủ đề chuyên biệt (Từ vựng, Ngữ pháp, Luyện nghe, Luyện nói).
*   Nhúng trình phát video Pop-up Iframe mượt mà, tối ưu trải nghiệm học tập tập trung.

### 5. Quản Lý Từ Vựng Cá Nhân & Thống Kê
*   **Bảng số liệu**: Thống kê số từ đã nhớ từ hệ thống chính và số từ cá nhân tự thêm.
*   **Tạo từ vựng riêng**: Cho phép học viên tự nhập từ mới để lưu trữ và ôn tập dưới dạng thẻ flashcard cá nhân.
*   **Chuỗi Streak thông minh**: Tính toán chuỗi ngày học liên tục ở Backend. Nếu nghỉ học bất kỳ ngày nào, chuỗi sẽ tự động reset về từ đầu khi học viên quay lại học.

---

## 🚀 Hướng Dẫn Cài Đặt & Chạy Dự Án

### Yêu cầu hệ thống
*   PHP 8.1 trở lên (Đã bật extension `pdo_sqlite` và `sqlite3`).
*   Node.js v18 trở lên.
*   Composer.

### 1. Cài đặt & Chạy Backend (Laravel)
```bash
# Di chuyển vào thư mục backend
cd backend

# Cài đặt các thư viện PHP
composer install

# Tạo file cấu hình môi trường
cp .env.example .env

# Tạo file cơ sở dữ liệu SQLite trống
touch database/database.sqlite

# Tạo khóa ứng dụng
php artisan key:generate

# Tiến hành chạy migration và nạp dữ liệu mẫu
php artisan migrate:fresh --seed

# Khởi chạy máy chủ API
php artisan serve
```
*Backend API chạy tại địa chỉ:* `http://127.0.0.1:8000`.

### 2. Cài đặt & Chạy Frontend (Vue 3)
```bash
# Di chuyển vào thư mục frontend
cd ../frontend

# Cài đặt các thư viện Node
npm install

# Khởi chạy máy chủ phát triển frontend
npm run dev
```
*Frontend chạy tại địa chỉ:* `http://localhost:5173`.

---

## 🔑 Tài Khoản Thử Nghiệm

Đăng nhập bằng các tài khoản sau (Mật khẩu chung: `password123`):
*   **Học viên**: `student@test.com`
*   **Người dùng test**: `user@test.com`
*   **Quản trị viên**: `admin@test.com`
