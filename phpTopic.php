<?php
// ตรวจสอบข้อมูล
function validate_post($title, $content) {
    $errors = [];

    if (strlen($title) < 4 || strlen($title) > 140) {
        $errors[] = "ชื่อกระทู้ต้องยาว 4 ถึง 140 ตัวอักษร";
    }

    if (strlen($content) < 6 || strlen($content) > 2000) {
        $errors[] = "เนื้อหากระทู้ต้องยาว 6 ถึง 2000 ตัวอักษร";
    }

    return $errors;
}

$post = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $errors = validate_post($title, $content);

    if (empty($errors)) {
        $post = ['title' => htmlspecialchars($title), 'content' => htmlspecialchars($content)];
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตั้งกระทู้</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; margin: auto; }
        label, textarea, input { display: block; width: 100%; margin-bottom: 10px; }
        button { padding: 10px 20px; }
        .error { color: red; }
        .post { background-color: #f9f9f9; padding: 20px; margin-top: 20px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>ตั้งกระทู้</h1>

    <form method="post">
        <label for="title">ชื่อกระทู้:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>

        <label for="content">เนื้อหากระทู้:</label>
        <textarea id="content" name="content" rows="5" required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>

        <button type="submit">ตั้งกระทู้</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($post): ?>
        <div class="post">
            <h2><?= $post['title'] ?></h2>
            <p><?= nl2br($post['content']) ?></p>
        </div>
    <?php endif; ?>
</body>
</html>
