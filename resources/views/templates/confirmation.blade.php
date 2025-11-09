@props([
    'ticket_form' => [],
    'passenger_form' => [],
])
@php
    use App\Airports;
    use Carbon\Carbon;use Carbon\CarbonInterval;

    $fake    = fake();
    $from    = Airports::byIata($ticket_form['from']);
    $to      = Airports::byIata($ticket_form['to']);
    $flyTime = CarbonInterval::hours($fake->numberBetween(1, 24))
        ->minutes($fake->numberBetween(0, 59))
        ->cascade()
        ->forHumans();
    $passenger = Arr::first($passenger_form['passengers']);
    $price = Number::currency($fake->randomFloat(2, 300, 2000), 'USD');

    @endphp
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение бронирования</title>
</head>
<body style="margin:0; padding:0; font-family: DejaVu Sans, Arial, sans-serif; font-size: 13px; color:#222;">

<div style="width: 800px; margin: 0 auto; padding: 24px 32px; box-sizing: border-box;">

    <!-- Шапка с логотипом и основной строкой -->
    <table style="width:100%; border-collapse:collapse; margin-bottom: 16px;">
        <tr>
            <td style="width:40%; vertical-align:top;">
                <!-- Логотип Turkish Airlines -->
                <img src="{{ public_path('images/turkish.svg') }}"
                     alt="Turkish Airlines"
                     style="height:48px;">
            </td>
            <td style="width:60%; text-align:right; vertical-align:top;">
                <div style="font-size:20px; font-weight:bold; margin-bottom:8px;">
                    Подтверждение бронирования
                </div>
                <div>
                    <span style="font-weight:bold;">Бронирование:</span>
                    114023&nbsp;|&nbsp;{!! $passenger_form['email'] !!}&nbsp;|
                    <span style="font-weight:bold;">Дата бронирования:</span>
                    {!! now()->format('d.m.Y H:i') !!}
                </div>
            </td>
        </tr>
    </table>

    <!-- Инфо-предупреждение -->
    <div style="margin-bottom: 16px; line-height:1.4;">
        Проверьте информацию о терминале и выходе на посадку у авиакомпании минимум за
        24 часа до вылета
    </div>

    <!-- Раздел: Детали рейса -->
    <div style="margin-top: 8px; margin-bottom: 18px;">
        <div
            style="font-size:16px; font-weight:bold; border-bottom:1px solid #ccc; padding-bottom:4px; margin-bottom:8px;">
            Детали рейса
        </div>

        <div style="font-weight:bold; margin-bottom:6px;">Рейс туда</div>

        <!-- Блок с авиакомпанией / рейсом / самолетом / классом -->
        <table style="width:100%; border-collapse:collapse; margin-bottom:10px; font-size:13px;">
            <tr>
                <td style="padding:4px 0;">Turkish Airlines</td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Рейс {!! rand(10, 100) !!}</td>
            </tr>
            <tr>
                <td style="padding:2px 0;">{!! sprintf('Самолет: Airbus A%d-%d', rand(100, 999), rand(100, 900)) !!}</td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Эконом</td>
            </tr>
        </table>

        <!-- Дата/город вылета, время вылета, дата/город прилёта, время прилёта -->
        <table style="width:100%; border-collapse:collapse; margin-bottom:10px; font-size:13px;">
            <tr>
                <!-- Левая колонка: вылет -->
                <td style="width:50%; vertical-align:top; padding-right:10px; border-right:1px solid #ddd;">
                    <div style="margin-bottom:4px;">{!! Carbon::make($ticket_form['date_from'])->format('d.m.Y') !!}</div>
                    <div style="margin-bottom:4px;">{!! sprintf('%s (%s)', $from['city'], $from['iata']) !!}</div>
                    <div style="margin-top:8px;">{!! sprintf('%s - %s', $from['iata'], $fake->time('H:i')) !!}</div>
                </td>

                <!-- Правая колонка: прилёт -->
                <td style="width:50%; vertical-align:top; padding-left:10px;">
                    <div style="margin-bottom:4px;">{!! Carbon::make($ticket_form['date_to'])->format('d.m.Y') !!}</div>
                    <div style="margin-bottom:4px;">{!! sprintf('%s (%s)', $to['city'], $to['iata']) !!}</div>
                    <div style="margin-top:8px;">{!! sprintf('%s - %s', $to['iata'], $fake->time('H:i')) !!}</div>
                </td>
            </tr>
        </table>

        <!-- Время в пути + номер брони -->
        <table style="width:100%; border-collapse:collapse; font-size:13px; margin-bottom:8px;">
            <tr>
                <td style="width:50%; vertical-align:top; padding-right:10px;">
                    <div style="font-weight:bold; margin-bottom:2px;">Время в пути:</div>
                    <div>{!! $flyTime !!}</div>
                </td>
                <td style="width:50%; vertical-align:top; padding-left:10px;">
                    <div style="font-weight:bold; margin-bottom:2px;">Номер бронирования:</div>
                    <div>{!! $fake->regexify('[A-Z]{5}[0-9]{3}') !!}</div>
                </td>
            </tr>
        </table>

        <div style="font-size:12px; color:#555; line-height:1.4; margin-top:6px;">
            Проверьте правила тарифа авиакомпании. Большинство авиакомпаний взимают плату за багаж,
            ознакомьтесь с условиями на сайте перевозчика.
        </div>
    </div>

    <!-- Раздел: Информация о пассажире -->
    <div style="margin-top: 12px; margin-bottom: 18px;">
        <div
            style="font-size:16px; font-weight:bold; border-bottom:1px solid #ccc; padding-bottom:4px; margin-bottom:8px;">
            Информация о пассажире
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <tr>
                <td style="width:35%; padding:4px 8px; background:#f5f5f5; font-weight:bold;">Номер билета</td>
                <td style="width:65%; padding:4px 8px;">{!! $fake->numerify('#############') !!}</td>
            </tr>
            <tr>
                <td style="padding:4px 8px; background:#f5f5f5; font-weight:bold;">Имя</td>
                <td style="padding:4px 8px;">{!! $passenger['first_name'] !!}</td>
            </tr>
            <tr>
                <td style="padding:4px 8px; background:#f5f5f5; font-weight:bold;">Фамилия</td>
                <td style="padding:4px 8px;">{!! $passenger['last_name'] !!}</td>
            </tr>
            <tr>
                <td style="padding:4px 8px; background:#f5f5f5; font-weight:bold;">Документ</td>
                <td style="padding:4px 8px;">{!! $passenger['document'] !!}</td>
            </tr>
        </table>

        <div style="font-size:12px; color:#555; line-height:1.4; margin-top:10px;">
            Внимание: не на всех рейсах предоставляется бесплатное питание. Все ваши пожелания будут
            переданы авиакомпании, но рекомендуем связаться с перевозчиком заранее для подтверждения
            возможности их выполнения.
        </div>
    </div>

    <!-- Раздел: Платежные данные -->
    <div style="margin-top: 12px;">
        <div
            style="font-size:16px; font-weight:bold; border-bottom:1px solid #ccc; padding-bottom:4px; margin-bottom:8px;">
            Платежные данные (USD)
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:13px; margin-bottom:12px;">
            <tr>
                <td style="width:35%; padding:4px 8px; background:#f5f5f5; font-weight:bold;">Способ оплаты</td>
                <td style="width:65%; padding:4px 8px;">
                    Банковская карта<br>
                    MasterCard<br>
                    {!! sprintf('************%d', $fake->numerify('####')) !!}
                </td>
            </tr>
        </table>

        <div style="font-weight:bold; margin-bottom:4px;">Детализация стоимости</div>

        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <tr>
                <td style="padding:3px 8px;">1 взрослый билет</td>
                <td style="padding:3px 8px; text-align:right;">{!! $price !!}</td>
            </tr>
            <tr>
                <td style="padding:3px 8px;">Скидка</td>
                <td style="padding:3px 8px; text-align:right;">Промо-скидка -0 $</td>
            </tr>
            <tr>
                <td style="padding:6px 8px; font-weight:bold; border-top: 1px solid #ddd;">Итого к оплате:</td>
                <td style="padding:6px 8px; font-weight:bold; text-align:right; border-top: 1px solid #ddd;">
                    {!! $price !!}
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
