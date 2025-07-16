{{-- <h2>聯絡表單來信</h2>
<p><strong>姓名：</strong> {{ $data['member_name'] }}</p>
<p><strong>Email：</strong> {{ $data['member_email'] }}</p>
<p><strong>訊息內容：</strong><br>{{ nl2br(e($data['member_note'])) }}</p> --}}

<table
    style="margin: 0; padding: 0 0 30px 0; background-color: #f4f5f7; font-family: Helvetica, Arial, Microsoft JhengHei, Microsoft YaHei"
    cellpadding="10" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tbody>
                        <tr>
                            <td style="font-size: 20px; margin: 0 0 15px 0; text-align: center; padding: 10px 0 10px 0">
                                <strong>{{ $data['mail_form_title'] }}</strong>
                            </td>
                        </tr>
                        <tr style="background-color: #aaa">
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td height="8"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="border: 1px dotted #d6d7d8; border-top: none; border-bottom: 3px solid #d6d7d8; background-color: #ffffff">
                                <table align="center" border="0" cellpadding="30" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="background-color: #ffffff; color: #456">
                                                感謝您的來信，我們已收到您的訊息，將儘快為您處理！這是您的詢問的副本記錄<br /><br />
                                                <span style="color: #f00">此信件為系統自動發出郵件，請勿直接回覆</span><br /><br />
                                                <table width="100%" border="1" align="center" cellpadding="4"
                                                    cellspacing="0" bordercolor="#CCC">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="background-color: #ffded9; line-height: 1.6">
                                                                <strong>個人基本資料</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="120" style="background-color: #e7e7e7">
                                                                姓名</td>
                                                            <td width="304" style="background-color: #fcfcfc">
                                                                {{ $data['member_name'] }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="background-color: #e7e7e7">
                                                                聯絡電話</td>
                                                            <td style="background-color: #fcfcfc">
                                                                {{ $data['member_phone'] }}
                                                            </td>

                                                        <tr>
                                                            <td width="120" style="background-color: #e7e7e7">
                                                                電子信箱</td>
                                                            <td width="304" style="background-color: #fcfcfc">
                                                                {{ $data['member_email'] }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="120" style="background-color: #e7e7e7">
                                                                公司名稱</td>
                                                            <td width="304" style="background-color: #fcfcfc">
                                                                {{ $data['member_company'] }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #e7e7e7">
                                                                洽詢項目</td>
                                                            <td style="background-color: #fcfcfc">
                                                                {{ $data['question_category'] }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #e7e7e7">
                                                                備註</td>
                                                            <td style="background-color: #fcfcfc">
                                                                {{ $data['member_note'] }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                    width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="
                                                                    padding: 20px 0 0 0;
                                                                    width: 100%;
                                                                    border-top: 1px dotted #e1e2e3;
                                                                    color: #9ab;
                                                                    font: normal 12px;
                                                                    text-align: center;
                                                                ">
                                                                All rights reserved.
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
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>