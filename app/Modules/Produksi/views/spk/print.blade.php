<!DOCTYPE html>
<html>
<head>
    <title>FORM FORMULA</title>
    <style type="text/css">
        * {
            font-size: 12px;
        }

        .s16 {
            font-size: 14px !important;
        }

        .div-width {
            margin: auto;
            width: 95vw;
        }

        .underline {
            text-decoration: underline;
        }

        .italic {
            font-style: italic;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .border-none-right {
            border-right: hidden;
        }

        .border-none-left {
            border-left: hidden;
        }

        .border-none-top {
            border-top: hidden;
        }

        .border-none-bottom {
            border-bottom: hidden;
        }

        .border-none-all {
            border: hidden;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .top {
            vertical-align: text-top;
        }

        .vertical-baseline {
            vertical-align: baseline;
        }

        .bottom {
            vertical-align: text-bottom;
        }

        .ttd {
            top: 0;
            position: absolute;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .empty {
            height: 15px;
        }

        table, td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        table.border-none, .border-none td, .border-none tr {
            border: none !important;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }

        @page {
            size: landscape;
            margin: 0;
        }

        .div-page-break {
            page-break-after: always;
        }

        .border-hidden tr, .border-hidden td {
            border: hidden;
        }

        .btn-print {
            right: 10px;
            position: absolute;
        }
    </style>
</head>
<body>
<div class="btn-print">
    <button onclick="javascript:window.print();">Print</button>
</div>
<div class="div-width">

    @for($i=0;$i<count($formula);$i++)

        <div class="div-page-break">
            <h1 class="s16">TAMMA ROBAH INDONESIA</h1>
            <table class="border-none" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="s16 underline bold text-center" colspan="3">FORM FORMULA</td>
                </tr>
                <tr>
                    <td width="70%">
                        No. SPK : <label class="bold">{{$spk[0]['spk_code']}}</label><br>
                        Tanggal Rencana : <label
                                class="bold">{{date('d M Y', strtotime($spk[0]['pp_date']))}}</label><br>

                    </td>
                    <td>
                        Item : <label class="bold">{{$spk[0]['i_name']}}</label><br>
                        Jumlah : <label class="bold">{{$spk[0]['pp_qty']}}</label><br>

                    </td>
                </tr>
            </table>
            <table width="100%" cellpadding="3px" class="tabel" border="1px">
                <tr class="text-center">
                    <td>No</td>
                    <td>Kode Item</td>
                    <td>Nama Item</td>
                    <td>Kebutuhan</td>
                    <td>Satuan</td>
                </tr>

                @for($j=0;$j<count($formula[$i]);$j++)
                    <tr>
                        <td width="1%" class="text-center">{{$j+1}}</td>
                        <td>{{$formula[$i][$j]['i_code']}}</td>
                        <td>{{$formula[$i][$j]['i_name']}}</td>
                        <td width="1%">{{$formula[$i][$j]['fr_value']}}</td>
                        <td width="1%">{{$formula[$i][$j]['m_sname']}}</td>
                    </tr>
                @endfor


                <?php
                $kosong = [];
                $hitung = 14 - count($formula[$i]);

                for ($a = 0; $a < $hitung; $a++) {
                    array_push($kosong, 'a');
                }
                ?>
                @foreach($kosong as $index => $we)
                    <tr>
                        <td class="text-center empty"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach


            </table>

        </div>

    @endfor

</div>
</body>
</html>