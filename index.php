<?php 

require 'functions.php';

$styles = [
    'Минимализм',
    'Классический',
    'Скандинавский',
    'Индустриальный',
    'Ар-деко',
    'Рустик',
    'Модерн',
    'Бохо',
    'Эклектичный',
    'Прованс',
];

if(isset($_POST['words'])){
    $word = $_POST['words'];
} else {
    $word = "";
};

if (isset($_POST['style'])) {
    $prompt = 'Напиши текст по теме стиля интерьера '. $_POST['style'];

    if (isset($_POST['words']) && $_POST['words']) {
        $prompt .= ', используя ключевые слова "' .$_POST['words']. '"';
    }

    $answer = chatgpt($prompt);

    $imageprompt = 'Переведи на английский язык "' . $answer . '"';
    $image = generateImage($imageprompt);
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Выбор стиля интерьера</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form class="mt-3" method="POST">
                    <div class="mb-3">
                        <select class="form-select" name="style" require>
                            <option selected disabled>Выберите стиль интерьера</option>
                            <?php foreach($styles as $style) : ?>
                                <option <?= ($_POST['style'] ?? '') == $style ? 'selected' : '' ?>><?= $style ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="words" class="form-label">Ключевые детали, которые бы Вы хотели видеть в своем интерьере</label>
                        <textarea rows="4" class="form-control" id="words" name="words"><?= $_POST['words'] ?? '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>

                <?php if (isset($answer)): ?>
                    <div class="mt-3">
                        <p class="mt-3">
                            <?= $answer ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (isset($image)): ?>
                    <div class="mt-3">
                        <img src="<?= $image ?>" alt="Сгенерированное изображение">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>