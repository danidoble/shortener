import {qr_config} from "./qr_config.js";
import QRCodeStyling from "qr-code-styling";

function makeQr(url) {
    const download_config = {...qr_config};
    download_config.data = url;
    download_config.margin = 10;
    const download_qr = new QRCodeStyling(download_config);
    download_qr.append(document.getElementById("download_qr"));
    window.download_qr = download_qr;

    const config = {...qr_config};
    config.data = url;
    config.height = 140;
    config.width = 140;
    const qr = new QRCodeStyling(config);
    qr.append(document.getElementById("qr"));
    // window.qr = qr;
}

window.makeQr = makeQr;
