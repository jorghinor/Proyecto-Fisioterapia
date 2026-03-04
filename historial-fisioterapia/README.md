# Sistema de Historial Clínico de Fisioterapia

## Backend
cd backend
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate:fresh --seed
php artisan serve

Usuarios:
- Admin: admin@example.com / admin123
- User: user@example.com / user123

## Frontend
cd frontend
npm install
npm run dev
