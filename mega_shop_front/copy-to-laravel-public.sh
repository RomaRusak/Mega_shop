SOURCE_DIR="./dist"
LARAVEL_PUBLIC_JS_DIR="../public/js"
JS_FILE="app.js"
LARAVEL_PUBLIC_CSS_DIR="../public/css"
CSS_FILE="styles.css"

if [ ! -d "$LARAVEL_PUBLIC_JS_DIR" ]; then
  mkdir -p "$LARAVEL_PUBLIC_JS_DIR"
  echo "Директория public/js не существовала, и была создана."
fi

if [ -f "$LARAVEL_PUBLIC_JS_DIR/$JS_FILE" ]; then
  rm "$LARAVEL_PUBLIC_JS_DIR/$JS_FILE"
  echo "Старый файл $JS_FILE удален из папки public/js."
fi

if [ ! -d "$LARAVEL_PUBLIC_CSS_DIR" ]; then
  mkdir -p "$LARAVEL_PUBLIC_CSS_DIR"
  echo "Директория public/css не существовала, и была создана."
fi

if [ -f "$LARAVEL_PUBLIC_CSS_DIR/$CSS_FILE" ]; then
  rm "$LARAVEL_PUBLIC_CSS_DIR/$CSS_FILE"
  echo "Старый файл $CSS_FILE удален из папки public/css."
fi

cp "$SOURCE_DIR/$JS_FILE" "$LARAVEL_PUBLIC_JS_DIR/$JS_FILE"
cp "$SOURCE_DIR/$CSS_FILE" "$LARAVEL_PUBLIC_CSS_DIR/$CSS_FILE"