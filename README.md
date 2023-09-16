## Тестовое задание
Реализовать программу+API на Laravel или UmiCMS, которая считает зарплату сотрудников. Сотрудники работают на почасовой основе. Ежедневно они присылают кол-во отработанных часов. Выплата зарплаты сотрудникам осуществляется в произвольный момент времени по запросу. В дальнейшем предполагается введение оплаты на основе оклада с фиксированной суммой в неделю (пока не требует разработки).

Программа через API должна иметь возможность:
- Создавать сотрудников
- Принимать от сотрудника транзакции с кол-вом отработанных за день часов
- Выводить суммы зарплат, которые еще не были выплачены (сотрудник => сумма)
- Выплачивать всю накопившуюся сумму по запросу

Следует покрыть все приложение тестами (или, как минимум, предложить, каким образом это может быть реализовано). В качестве суммы за час возьмите любое число.

UseCases:
- Создание сотрудника: email, password. Пароль в базе должен быть зашифрован.
- Принятие транзакции: employee_id, hours. Создает запись в базе.
- Вывод суммы: входных данных нет; на выходе json формата `[ { employee_id : сумма выплат } ]`
- Выплата всей накопившейся суммы: входных и выходных данных нет, все транзакции становятся погашенными

Выполненное задание нужно опубликовать в GIT и прислать ссылку. GIT должен содержать как минимум 2 коммита: начальный (инициализация приложения) и конечный (выполненное задание).

## Установка
- скопировать .env.example в .env
- в .env установить соединение с БД, в .env.testing установить соединение с тестовой БД
```
    composer install
```
```
    php artisan test
```
```
    php artisan serve
```
### Использование

| Метод запроса  | Эндпоинт                 | Описание                                               |
| -------------- |:------------------------:|--------------------------------------------------------|
| POST           | /api/employee/create     | создание сотрудника                                    |
| POST           | /api/transaction/create  | создание транзакции                                    |
| GET            | /api/transaction/index   | вывод суммы непроведенных транзакций                   |
| POST           | /api//transaction/conduct| проведение транзакции(выплата всей суммы)              |
