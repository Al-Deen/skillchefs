<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

    body {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    div,
    p,
    a,
    li,
    td {
        -webkit-text-size-adjust: none;
    }

    .ReadMsgBody {
        width: 100%;
        background-color: #ffffff;
    }

    .ExternalClass {
        width: 100%;
        background-color: #ffffff;
    }

    body {
        width: 100%;
        height: 100%;
        background-color: #fff;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
    }

    html {
        width: 100%;
    }

    p {
        padding: 0 !important;
        margin-top: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 0 !important;
        margin-left: 0 !important;
    }

    @media only screen and (max-width: 600px) {
        body {
            width: auto !important;
        }

        table[class=fullTable] {
            width: 96% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 45% !important;
        }

        .erase {
            display: none;
        }
    }

    @media only screen and (max-width: 420px) {
        table[class=fullTable] {
            width: 100% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 100% !important;
            clear: both;
        }

        table[class=col] td {
            text-align: left !important;
        }

        .erase {
            display: none;
            font-size: 0;
            max-height: 0;
            line-height: 0;
            padding: 0;
        }

        .visibleMobile {
            display: block !important;
        }

        .hiddenMobile {
            display: none !important;
        }
    }

    .fullTable,.fullPadding {
        width: 100%;
    }
</style>

<table class="table">

    <!-- Header -->
    <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#fff">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff"
                    style="border-radius: 10px 10px 0 0;">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="width-50" width="220" border="0" cellpadding="0" cellspacing="0"
                                                align="left" class="col">
                                                <tbody>
                                                    <tr>
                                                        <td align="left"> <img src="{{ showImage(setting('light_logo'), 'logo.png') }}"
                                                                alt="logo" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                            {{ $data['enroll']->user->name }}<br />
                                                            {{ $data['enroll']->user->email }}<br />
                                                            {{ $data['enroll']->user->phone }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="width-50" width="220" border="0" cellpadding="0" cellspacing="0"
                                                align="right" class="col">
                                                <tbody>
                                                    <tr class="visibleMobile">
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="5"></td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 21px; color: #ff0000; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                                            {{ ___('common.Invoice') }}
                                                        </td>
                                                    </tr>
                                                    <tr class="hiddenMobile">
                                                        <td height="50"></td>
                                                    </tr>
                                                    <tr class="visibleMobile">
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                                                            <small>{{ ___('common.ORDER') }}</small>
                                                            #{{ $data['enroll']->id }}<br/>
                                                            <small>{{ date('d-m-Y', strtotime($data['enroll']->created_at)) }}</small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- /Header -->
    <!-- Order Details -->
    <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#fff">
        <tbody>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                        bgcolor="#ffffff">
                        <tbody>
                            <tr class="hiddenMobile">
                                <td height="60"></td>
                            </tr>
                            <tr class="visibleMobile">
                                <td height="40"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                                        class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;"
                                                    width="52%" align="left">
                                                    {{ ___('course.Course') }}
                                                </th>
                                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                    align="left">
                                                    <small>
                                                        {{ ___('course.Price') }}
                                                    </small>
                                                </th>
                                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                    align="center">
                                                    {{ ___('common.Quantity') }}
                                                </th>
                                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                    align="right">
                                                    {{ ___('common.Discount') }}
                                                </th>
                                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                    align="right">
                                                    {{ ___('common.Subtotal') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td height="1" style="background: #bebebe;" colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <td height="10" colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                    class="article">
                                                    {{ $data['enroll']->course->title }}
                                                </td>
                                                <td
                                                    style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;">
                                                    <small>
                                                        {{ showPrice(@$data['enroll']->orderItem->amount) }}
                                                    </small>
                                                </td>
                                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                    align="center">1</td>
                                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                    align="right">
                                                    <small>
                                                        {{ showPrice(@$data['enroll']->orderItem->discount_amount) }}
                                                    </small>
                                                </td>
                                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                    align="right">
                                                    <small>
                                                        {{ showPrice(@$data['enroll']->orderItem->total_amount) }}
                                                    </small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="1" colspan="5"
                                                    style="border-bottom:1px solid #e4e4e4"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- /Order Details -->
    <!-- Total -->
    <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#fff">
        <tbody>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                        bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td>

                                    <!-- Table Total -->
                                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                                        class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    {{ ___('common.Subtotal') }}
                                                </td>
                                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                    width="80">
                                                    {{ showPrice(@$data['enroll']->orderItem->total_amount) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong>{{ ___('common.Grand Total') }}</strong>
                                                </td>
                                                <td
                                                    style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong>{{ showPrice(@$data['enroll']->orderItem->total_amount) }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- /Table Total -->

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- /Total -->
    <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#fff">

        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                    bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" align="center"
                                class="fullPadding">
                                <tbody>
                                    <tr>
                                        <td
                                            style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                            <p class="text-uppercase">
                                                <strong>{{ ___('common.In Words:') }}</strong>{{ numberTowords(@$data['enroll']->orderItem->total_amount) }}
                                                {{ ___('common.Only .') }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="spacer">
                        <td height="50"></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td height="20"></td>
        </tr>
    </table>
</table>
