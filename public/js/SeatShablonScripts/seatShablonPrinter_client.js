
export class seatShablonPrinter
{
    constructor(visualDiscriptionSeats, visualDiscriptionTickets)
    {
        this.visualDiscriptionSeats = visualDiscriptionSeats;
        this.visualDiscriptionTickets = visualDiscriptionTickets;
        this.price = 0;
        this.buggegePrice = 0;
    }

    updateSeatShablonVisualFromObject_client(seatStructure, ticketsOrderListObj)
    {
        this.updateSeatShablonFromObject_client(seatStructure, ticketsOrderListObj);
        this.updateOrdetedTickets(ticketsOrderListObj);
    }


    updateSeatShablonFromObject_client(seatStructureObject, ticketsOrderListObj) {
        this.visualDiscriptionSeats.innerHTML = '';
        this.visualDiscriptionSeats.innerHTML = this.printSeatShablonFromObject_GetHTML_client(seatStructureObject);
        this.printSeatShablonFromObject_AddButtonListeners_withChecker_client(seatStructureObject, ticketsOrderListObj);
    }

    updateOrdetedTickets(ticketsOrderListObj)
    {
        this.visualDiscriptionTickets.innerHTML = '';
        this.visualDiscriptionTickets.innerHTML = this.printOrdetedTickets(ticketsOrderListObj);
        this.printOrdetedTickets_AddButtonListeners(ticketsOrderListObj);
    }



    printSeatShablonFromObject_GetHTML_client(seatStructureObject)
    {
        let classCounter = 0;
        let seatCounter = 0;
        let htmlText = ``;

        for (let planeClass of seatStructureObject.classes) {

            let classType = planeClass.classType;
            let readableClassCounter = classCounter + 1;

            htmlText += `<div class="plane_class">
                        <div class="tablo">
                            <h1>Класс номер: ${readableClassCounter}, тип: ${classType}</h1>
                        </div>
                        <div class="class_zones">`;

            let zoneCounter = 0;

            for (let zone of planeClass.zones) {

                let zoneId = `${classCounter}_${zoneCounter}`;

                htmlText += `<div class="class_zone">`;

                let sectorCounter = 0;

                for (let sector of zone.sectors) {

                    htmlText += `<div class="zone_sector_panel">
                                <div>
                                 <div class="zone_sector">`;

                    for (let row of sector.rows) {

                        htmlText += `<div class="sector_row">`;
                        for (let seat of row.seats) {
                            let seatID = `setSeatStatusBTN${seatCounter}`
                            if (seat.available === true) {
                                if (seat._chosen === true){
                                    htmlText += `<div id="${seatID}" class="row_seat chosen"><button type="button" class="seat-btn"></button></div>`;
                                } else {
                                    htmlText += `<div id="${seatID}" class="row_seat"><button type="button" class="seat-btn"></button></div>`;
                                }
                            } else {
                                htmlText += `<div id="${seatID}" class="row_seat blocked"><button type="button" class="seat-btn"></button></div>`;
                            }
                            seatCounter++;
                        }

                        htmlText += `</div>`;
                    }
                    htmlText += `</div>
                                 </div>
                                 </div>`; // конец zone_sector
                    sectorCounter++;
                }

                htmlText += `</div>`; // конец class_zone
                zoneCounter++;
            }
            htmlText += `</div></div>`; // конец class_zones и plane_class
            classCounter++;
        }
        return htmlText;
    }

    printSeatShablonFromObject_AddButtonListeners_withChecker_client(seatStructureObject, ticketsOrderListObj)
    {
        let classCounter = 0;
        let seatCounter = 0;

        for (let planeClass of seatStructureObject.classes) {

            let zoneCounter = 0;

            for (let zone of planeClass.zones) {


                let sectorCounter = 0;

                for (let sector of zone.sectors) {

                    for (let row of sector.rows) {

                        for (let seat of row.seats) {
                            this.addSetSeatStatusButtonListener_client(seatStructureObject, seat, seatCounter, ticketsOrderListObj);
                            seatCounter++
                        }

                    }
                    sectorCounter++;
                }
                zoneCounter++;
            }
            classCounter++;
        }

    }

    addSetSeatStatusButtonListener_client(seatStructureObject, seat, seatCounter, ticketsOrderListObj)
    {
        let SetSeatStatusBtnId = `setSeatStatusBTN${seatCounter}`;
        let SetSeatStatusBTN = document.getElementById(SetSeatStatusBtnId);

        SetSeatStatusBTN.addEventListener('click', () => {
            let currentStatus = seat._available;
            let currentChoseStatus = seat._chosen;
            // seat._available = !currentStatus;
            seat._chosen = !currentChoseStatus;

            let seatId = seat._seatId
            if (currentStatus == true){
                if (currentChoseStatus == false)
                {
                    ticketsOrderListObj.addTicket(seatId);
                } else
                {
                    ticketsOrderListObj.delTicket(seatId);
                }
            }

            this.updateSeatShablonVisualFromObject_client(seatStructureObject, ticketsOrderListObj);
        });
    }

    printOrdetedTickets(ticketsOrderListObj)
    {
        let htmlText = ``;

        let seatCount = 1;

        let finalPriceSum = 0;
        for (let ticket of ticketsOrderListObj.tickets)
        {
            let haveExtraBuggage = ticket[1];


            let btnId = `btnId${seatCount}`;
            let buttonLable = haveExtraBuggage ? "Да" : "Нет";

            let tiketPrice = this.price;
            let ticketPriceWithBaggege = this.price + this.buggegePrice;
            let finalPrice = haveExtraBuggage ?  ticketPriceWithBaggege : tiketPrice;
            finalPriceSum += finalPrice;

            htmlText += `
                <tr>
                    <td>${seatCount}</td>
                    <td>${tiketPrice} руб</td>
                    
                    <td>
                        <button id="${btnId}">${buttonLable}</button>
                    </td>
                    <td>${finalPrice} руб</td>
                </tr>
            `;

            seatCount++;
        }
        htmlText += `<td colspan="3">Итоговая цена заказа:</td>
                    <td>${finalPriceSum} руб</td>`;

        return htmlText;
    }

    printOrdetedTickets_AddButtonListeners(ticketsOrderListObj)
    {
        let seatCount = 1;
        for (let ticket of ticketsOrderListObj.tickets)
        {
            let seatId = ticket[0];

            this.addExtraBuggagesetterOrderButtonListener(ticketsOrderListObj, seatCount, seatId);

            seatCount++;
        }
    }

    addExtraBuggagesetterOrderButtonListener(ticketsOrderListObj, seatCount, seatId)
    {
        let btnId = `btnId${seatCount}`;
        let btn = document.getElementById(btnId);

        btn.addEventListener('click', () => {
            ticketsOrderListObj.changeBaggageStatus(seatId);

            this.updateOrdetedTickets(ticketsOrderListObj)
        });
    }


}

