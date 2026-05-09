<mjml>
    <mj-head>
        <!-- style -->
        <mj-style inline="inline">
            body {
                background-color: #ffdfd9;
                padding: 10px;
            }

            .table tr:nth-child(odd) {
                background-color: #f3f3f3;
            }

            .table td {
                padding: 3px 10px;
            }
        </mj-style>
    </mj-head>
    <mj-body>
        <mj-raw>
            @php
                use App\Http\Controllers\ImageController; // don't remove

                $request = $parameters["request"];
            @endphp
        </mj-raw>
        <mj-section>
            <mj-column>
                <mj-image width="400px" src="{{ImageController::toBase64('images/logo.png')}}"></mj-image>
            </mj-column>
        </mj-section>
        <mj-section padding-top="0px">
            <mj-column background-color="#ffffff" padding="20px" padding-left="0px" padding-right="0px">
                <mj-text font-size="25px" color="#e8644a" font-family="helvetica">Richiesta di progetto</mj-text>
                
                <mj-divider border-color="#e8644a"></mj-divider>
                
                <mj-table css-class="table" font-size="16px">
                    <tr>
                        <td><b>Nome</b></td>
                        <td>{{$request["first_name"]}}</td>
                    </tr>
                    <tr>
                        <td><b>Cognome</b></td>
                        <td>{{$request["last_name"]}}</td>
                    </tr>
                    <tr>
                        <td><b>Lingua</b></td>
                        <td>{{mb_strtoupper($request["language"])}}</td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>{{$request["email"]}}</td>
                    </tr>
                    <tr>
                        <td><b>Telefono</b></td>
                        <td>{{$request["phone"]}}</td>
                    </tr>
                    <tr>
                        <td><b>Indirizzo</b></td>
                        <td>{{$request["address"]}}, {{$request["city"]}} ({{$request["province"]}})</td>
                    </tr>
                    <tr>
                        <td><b>Foto</b></td>
                        <td>{{count($request["photos"])}} <i>(in allegato)</i></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>Richiesta</b><br>
                            {{$request["request"]}}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Privacy</b></td>
                        <td>{{$request["privacy"] == "on" ? "Accettata" : "Non Accettata"}}</td>
                    </tr>
                </mj-table>
            </mj-column>
        </mj-section>
        
        <!-- Footer -->
        <mj-section padding="0px">
            <mj-column>
                <mj-text font-size="12px" padding-top="20px" color="#e8644a" font-family="helvetica" align="center">
                    <x-email.footer />
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>