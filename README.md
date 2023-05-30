# Vk Events Api
Разработаны методы для сохранения событий и получения статистики (папка include):
1. add_event
Метод принимает в качестве входных параметров название события и статус пользователя. Затем добавляется вспомогательная информация и сохраняется событие.
2. get_events
Метод фильтрует по дате и названию события и получает агрегированную информацию (по одному из 3-х столбцов) : название события, IP-пользователя, статус пользователя
# Рабочее Api (бесплатный доступ до 30.05)
https://vkevents-production.up.railway.app/
# Инструкция
1. Для добавления события нужно ввести название события, отметить авторизованность и нажать "Добавить" 
2. Для фильтрации событий нужно во втором блоке ввести название события, даты и нажать "Поиск"
3. Чтобы агрегировать по какому-либо столбцу нужно открыть соответствующий выпадающий список и выбрать нужный вариант
# Используемые технологии
1. Язык: PHP, SQL
2. База данных: MySQL
3. Платформа для развертывания, хостинг: Railway
