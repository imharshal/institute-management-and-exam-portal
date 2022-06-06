<?php function paymentmail($statustext, $statusimage, $subject,$isErr)
{
    $color = (str_contains($subject, 'Successful')) ? '#5cb85c' : '#d9534f';
    return '

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

    <head>
        <!--[if gte mso 9
      ]><xml
        ><o:OfficeDocumentSettings
          ><o:AllowPNG /><o:PixelsPerInch
            >96</o:PixelsPerInch
          ></o:OfficeDocumentSettings
        ></xml
      ><!
    [endif]-->
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <meta content="width=device-width" name="viewport" />
        <!--[if !mso]><!-->
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <!--<![endif]-->
        <title></title>
        <!--[if !mso]><!-->
        <!--<![endif]-->
        <style type="text/css">
            body {
                margin: 0;
                padding: 0;
            }

            table,
            td,
            tr {
                vertical-align: top;
                border-collapse: collapse;
            }

            * {
                line-height: inherit;
            }

            a[x-apple-data-detectors="true"] {
                color: inherit !important;
                text-decoration: none !important;
            }
        </style>
        <style id="media-query" type="text/css">
            @media (max-width: 605px) {

                .block-grid,
                .col {
                    min-width: 320px !important;
                    max-width: 100% !important;
                    display: block !important;
                }

                .block-grid {
                    width: 100% !important;
                }

                .col {
                    width: 100% !important;
                }

                .col_cont {
                    margin: 0 auto;
                }

                img.fullwidth,
                img.fullwidthOnMobile {
                    max-width: 100% !important;
                }

                .no-stack .col {
                    min-width: 0 !important;
                    display: table-cell !important;
                }

                .no-stack.two-up .col {
                    width: 50% !important;
                }

                .no-stack .col.num2 {
                    width: 16.6% !important;
                }

                .no-stack .col.num3 {
                    width: 25% !important;
                }

                .no-stack .col.num4 {
                    width: 33% !important;
                }

                .no-stack .col.num5 {
                    width: 41.6% !important;
                }

                .no-stack .col.num6 {
                    width: 50% !important;
                }

                .no-stack .col.num7 {
                    width: 58.3% !important;
                }

                .no-stack .col.num8 {
                    width: 66.6% !important;
                }

                .no-stack .col.num9 {
                    width: 75% !important;
                }

                .no-stack .col.num10 {
                    width: 83.3% !important;
                }

                .video-block {
                    max-width: none !important;
                }

                .mobile_hide {
                    min-height: 0px;
                    max-height: 0px;
                    max-width: 0px;
                    display: none;
                    overflow: hidden;
                    font-size: 0px;
                }

                .desktop_hide {
                    display: block !important;
                    max-height: none !important;
                }
            }
        </style>
        <style id="icon-media-query" type="text/css">
            @media (max-width: 605px) {
                .icons-inner {
                    text-align: center;
                }

                .icons-inner td {
                    margin: 0 auto;
                }
            }
        </style>
    </head>

    <body class="clean-body" style="
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      background-color: #f8f8f9;
    ">
        <!--[if IE]><div class="ie-browser"><![endif]-->
        <table bgcolor="#f8f8f9" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="
        table-layout: fixed;
        vertical-align: top;
        min-width: 320px;
        border-spacing: 0;
        border-collapse: collapse;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        background-color: #f8f8f9;
        width: 100%;
      " valign="top" width="100%">
            <tbody>
                <tr style="vertical-align: top" valign="top">
                    <td style="word-break: break-word; vertical-align: top" valign="top">
                        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#f8f8f9"><![endif]-->
                        <div>
                            <div class="block-grid" style="
                  min-width: 320px;
                  max-width: 585px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: #ffffff;
                ">
                                <div style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: #ffffff;
                  ">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:585px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="585" style="background-color:#ffffff;width:585px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
                                    <div class="col num12" style="
                      min-width: 320px;
                      max-width: 585px;
                      display: table-cell;
                      vertical-align: top;
                      width: 585px;
                    ">
                                        <div class="col_cont" style="width: 100% !important">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 0px;
                          padding-bottom: 0px;
                          padding-right: 0px;
                          padding-left: 0px;
                        ">
                                                <!--<![endif]-->
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          " valign="top" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top" valign="top">
                                                            <td class="divider_inner" style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 10px;
                                  padding-right: 10px;
                                  padding-bottom: 10px;
                                  padding-left: 10px;
                                " valign="top">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 5px solid #1aa19c;
                                    width: 100%;
                                  " valign="top" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top" valign="top">
                                                                            <td style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        " valign="top">
                                                                                <span></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center fixedwidth" style="padding-right: 25px; padding-left: 25px">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 25px;padding-left: 25px;" align="center"><![endif]-->
                                                    <div style="font-size: 1px; line-height: 25px"> </div>
                                                    <img align="center" border="0" class="center fixedwidth" src="https://testing.ssdit.in/img/ssd-logo-with-text.png" style="
                              text-decoration: none;
                              -ms-interpolation-mode: bicubic;
                              height: auto;
                              border: 0;
                              width: 100%;
                              max-width: 117px;
                              display: block;
                            " width="117" />
                                                    <div style="font-size: 1px; line-height: 25px"> </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color: transparent">
                            <div class="block-grid" style="
                  min-width: 320px;
                  max-width: 585px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: #ffffff;
                ">
                                <div style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: #ffffff;
                  ">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:585px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="585" style="background-color:#ffffff;width:585px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
                                    <div class="col num12" style="
                      min-width: 320px;
                      max-width: 585px;
                      display: table-cell;
                      vertical-align: top;
                      width: 585px;
                    ">
                                        <div class="col_cont" style="width: 100% !important">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 0px;
                          padding-bottom: 0px;
                          padding-right: 0px;
                          padding-left: 0px;
                        ">
                                                <!--<![endif]-->
                                                <div align="center" class="img-container center fixedwidth" style="padding-right: 40px; padding-left: 40px">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 40px;padding-left: 40px;" align="center"><!
                          [endif]--><img align="center" alt="Image" border="0" class="center fixedwidth" src="' . $statusimage . '" style="
                              text-decoration: none;
                              -ms-interpolation-mode: bicubic;
                              height: auto;
                              border: 0;
                              width: 100%;
                              max-width: 146px;
                              display: block;
                            " title="Image" width="146" />
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          " valign="top" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top" valign="top">
                                                            <td class="divider_inner" style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 50px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                " valign="top">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 0px solid #bbbbbb;
                                    width: 100%;
                                  " valign="top" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top" valign="top">
                                                                            <td style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        " valign="top">
                                                                                <span></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, sans-serif"><![endif]-->
                                                <div style="
                            color: #555555;
                            font-family: Montserrat, Trebuchet MS, Lucida Grande,
                              Lucida Sans Unicode, Lucida Sans, Tahoma,
                              sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 40px;
                            padding-bottom: 10px;
                            padding-left: 40px;
                          ">
                                                    <div class="txtTinyMce-wrapper" style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #555555;
                              font-family: Montserrat, Trebuchet MS,
                                Lucida Grande, Lucida Sans Unicode, Lucida Sans,
                                Tahoma, sans-serif;
                              mso-line-height-alt: 14px;
                            ">
                                                        <p style="
                                margin: 0;
                                font-size: 22px;
                                line-height: 1.2;
                                text-align: center;
                                word-break: break-word;
                                mso-line-height-alt: 26px;
                                margin-top: 0;
                                margin-bottom: 0;
                              ">
                                                            <span style="font-size: 22px; color: ' . $color . '"><strong>' . $subject . '</strong></span><br><br>
                                                            <span style="color: #808389; font-size: 16px">' . $statustext . '</span>

                                                        </p>
                                                    </div>
                                                </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, sans-serif"><![endif]-->
                                                <div style="
                            color: #555555;
                            font-family: Montserrat, Trebuchet MS, Lucida Grande,
                              Lucida Sans Unicode, Lucida Sans, Tahoma,
                              sans-serif;
                            line-height: 1.5;
                            padding-top: 10px;
                            padding-right: 40px;
                            padding-bottom: 10px;
                            padding-left: 40px;
                          ">
                                                    <div class="txtTinyMce-wrapper" style="
                              line-height: 1.5;
                              font-size: 12px;
                              font-family: Montserrat, Trebuchet MS,
                                Lucida Grande, Lucida Sans Unicode, Lucida Sans,
                                Tahoma, sans-serif;
                              color: #555555;
                              mso-line-height-alt: 18px;
                            ">
                                                        <p style="
                                margin: 0;
                                font-size: 15px;
                                line-height: 1.5;
                                text-align: center;
                                word-break: break-word;
                                mso-line-height-alt: 23px;
                                margin-top: 0;
                                margin-bottom: 0;
                              ">
                              
                                                            <span style="color: #808389; font-size: 15px">Here is a summary of your recent
                                                                transaction. </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color: transparent">
                            <div class="block-grid" style="
                  min-width: 320px;
                  max-width: 585px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: #ffffff;
                ">
                                <div style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: #ffffff;
                  ">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:585px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="585" style="background-color:#ffffff;width:585px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                    <div class="col num12" style="
                      min-width: 320px;
                      max-width: 585px;
                      display: table-cell;
                      vertical-align: top;
                      width: 585px;
                    ">
                                        <div class="col_cont" style="width: 100% !important">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        ">
                                                <!--<![endif]-->
                                                <div style="
                            font-size: 16px;
                            text-align: center;
                            font-family: Montserrat, Trebuchet MS, Lucida Grande,
                              Lucida Sans Unicode, Lucida Sans, Tahoma,
                              sans-serif;
                          "></div>
                                                <div style="
                            font-size: 16px;
                            text-align: center;
                            font-family: Montserrat, Trebuchet MS, Lucida Grande,
                              Lucida Sans Unicode, Lucida Sans, Tahoma,
                              sans-serif;
                          ">
                                                    <style>
                                                        table,
                                                        th {
                                                            font-size: 10;
                                                            min-width: 200px;
                                                        }

                                                        td {
                                                           font-size:10px;
                                                        }
                                                    </style>
                                                    <div style=" padding:10px; margin:0 auto;">
                                                        <table style="margin: 0 auto; padding: 10px; font-size:10px;">
                                                            <tbody style="text-align: left; line-height: 2.5">' .
        string_payment_table($_POST,$isErr)

        . '</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>

                        <div style="background-color: transparent">
                            <div class="block-grid" style="
                  min-width: 320px;
                  max-width: 585px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: #ffffff;
                ">
                                <div style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: #ffffff;
                  ">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:585px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="585" style="background-color:#ffffff;width:585px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                    <div class="col num12" style="
                      min-width: 320px;
                      max-width: 585px;
                      display: table-cell;
                      vertical-align: top;
                      width: 585px;
                    ">
                                        <div class="col_cont" style="width: 100% !important">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        ">
                                                <!--<![endif]-->
                                                <table cellpadding="0" cellspacing="0" role="presentation" style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                          " valign="top" width="100%">
                                                    <tr style="vertical-align: top" valign="top">
                                                        <td align="center" style="
                                word-break: break-word;
                                vertical-align: top;
                                padding-top: 5px;
                                padding-right: 0px;
                                padding-bottom: 5px;
                                padding-left: 0px;
                                text-align: center;
                              " valign="top">
                                                            <!--[if vml]><table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"><![endif]-->
                                                            <!--[if !vml]><!-->
                                                            <table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="
                                  table-layout: fixed;
                                  vertical-align: top;
                                  border-spacing: 0;
                                  border-collapse: collapse;
                                  mso-table-lspace: 0pt;
                                  mso-table-rspace: 0pt;
                                  display: inline-block;
                                  margin-right: -4px;
                                  padding-left: 0px;
                                  padding-right: 0px;
                                " valign="top">

                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                    </td>
                </tr>
            </tbody>
        </table>
        <!--[if (IE)]></div><![endif]-->
    </body>

    </html>
';
}
