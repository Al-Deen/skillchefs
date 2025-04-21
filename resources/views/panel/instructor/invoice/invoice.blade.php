<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sookh | Master Invoice</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
    <style media="all">
        * {
            font-family: DejaVu Sans, sans-serif;
        }

        body {
            font-size: 0.688rem;
        }

        .font-italic {
            font-style: italic;
        }


        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table td {
            font-family: 'SolaimanLipi', sans-serif !important;
        }

        table.padding th {
            padding: .25rem .7rem;
        }

        table.padding td,
        .row {
            padding: .25rem .7rem;
        }

        table.sm-padding td {
            padding: .1rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #fff;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .tr {
            background: #ddd
        }
    </style>
</head>

<body>
    <div style="margin-left:auto;margin-right:auto;">
        <div style="background: #fff">
            <div style="width: 100%;margin: auto;">
                <table>
                    <tr>
                        <td>
                            <img src="{{ showImage(setting('light_logo'), 'logo.png') }}"
                                alt="{{ setting('application_name') }}" height="30" style="display:inline-block;">
                        </td>
                        <td style="font-size: 2.5rem;" class="text-right strong"> {{ ___('common.Invoice') }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td class="text-right small">
                            <span class=" strong">#{{ $data['enroll']->id }}</span>
                            <br>
                            <span class=" strong">{{ date('d-m-Y', strtotime($data['enroll']->created_at)) }}</span>
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        <div style="border-bottom:1px solid #fff;margin: 0 1.5rem;"></div>

        <div style="width:100%;margin: auto;">
            <table class="padding text-left small border-bottom table-bordered">
                <thead>
                    <tr class="tr">
                        <th width="35%">{{ ___('course.Course') }}</th>

                        <th width="10%">{{ ___('course.Price') }}</th>
                        <th width="15%">{{ ___('common.Quantity') }}</th>

                        <th width="15%" class="text-right">{{ ___('common.Total') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    <tr style="border: 2px solid #000;">
                        <td>{{ $data['enroll']->course->title }} </td>
                        <td class="text-center">{{ showPrice(@$data['enroll']->orderItem->amount) }}</td>
                        <td class="text-center">1</td>
                        <td class="text-right">
                            {{ showPrice(@$data['enroll']->orderItem->total_amount) }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-xl-5 col-md-6 ml-auto mr-0">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="text-right">{{ ___('common.Subtotal') }}</th>
                                <td class="text-right">
                                    <span class="fw-600">
                                        {{ showPrice(@$data['enroll']->orderItem->total_amount) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">{{ ___('common.Total Amount') }}</th>
                                <td class="text-right">
                                    {{ showPrice(@$data['enroll']->orderItem->discount_amount) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">{{ ___('common.Total Amount') }}</th>
                                <td class="text-right">
                                    {{ showPrice(@$data['enroll']->orderItem->total_amount) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
