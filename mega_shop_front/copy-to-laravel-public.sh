SOURCE_DIR="./dist/js" 
LARAVEL_PUBLIC_DIR="../public/js"

cp -r "$SOURCE_DIR/"* "$LARAVEL_PUBLIC_DIR/"

echo "Результаты сборки скопированы в папку public Laravel."