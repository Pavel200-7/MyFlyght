
export class seatShablonPrinter
{
    constructor(visualDiscription)
    {
        this.visualDiscription = visualDiscription;
    }

    updateSeatShablonVisualFromObject(seatStructure)
    {
        this.clearSeatShablonVisual();
        this.printSeatShablonFromObject(seatStructure);
    }

    printSeatShablonFromObject(seatStructureObject) {
        this.visualDiscription.innerHTML = this.printSeatShablonFromObject_GetHTML(seatStructureObject);
        this.printSeatShablonFromObject_AddButtonListeners_withoutBlocker(seatStructureObject);
    }

    printSeatShablonFromObject_GetHTML(seatStructureObject)
    {
        let classCounter = 0;
        let seatCounter = 0;
        let htmlText = ``;

        for (let planeClass of seatStructureObject.classes) {

            let classType = planeClass.classType;
            let delClassBtnId = `delClassBTN${classCounter}`;
            let addZoneBtnId = `addZoneBTN${classCounter}`;
            let readableClassCounter = classCounter + 1;

            htmlText += `<div class="plane_class">
                        <div class="tablo">
                            <h1>Класс номер: ${readableClassCounter}, тип: ${classType}</h1>
                            <button type="button" id="${delClassBtnId}" class="btn aDelete toggleable">Удалить класс</button>
                            <button type="button" id="${addZoneBtnId}" class="btn aCreate toggleable">Добавить зону</button>
                        </div>
                        <div class="class_zones">`;

            let zoneCounter = 0;

            for (let zone of planeClass.zones) {

                let zoneId = `${classCounter}_${zoneCounter}`;
                let delZoneBtnId = `delZoneBTN${zoneId}`;
                let copyZoneBtnId = `copyZoneBTN${zoneId}`;

                htmlText += `<div class="class_zone">
                            <button type="button" id="${delZoneBtnId}" class="btn aDelete toggleable">Удалить зону</button>
                            <button type="button" id="${copyZoneBtnId}" class="btn aUpdate toggleable">Копировать зону</button>`;

                let sectorCounter = 0;

                for (let sector of zone.sectors) {

                    let sectorID = `${classCounter}_${zoneCounter}_${sectorCounter}`;

                    let delSectorBTN = `delSectorBTN${sectorID}`;
                    let copySectorBTN = `copySectorBTN${sectorID}`;

                    let delRowBTN = `delRowBTN${sectorID}`;
                    let addRowBTN = `addRowBTN${sectorID}`;
                    let delSeatsInRowBTN = `delSeatsInRowBTN${sectorID}`;
                    let addSeatsInBTN = `addSeatsInRowBTN${sectorID}`;

                    htmlText += `<div class="zone_sector_panel">
                                <div>
                                 <div>
                                     <button type="button" id="${delSectorBTN}" class="btn aDelete toggleable">Удалить сектор</button>
                                     <button type="button" id="${copySectorBTN}" class="btn aUpdate toggleable">Копировать сектор</button>
                                     <div>
                                         <button type="button" id="${delRowBTN}" class="btn some_crementButton delButton toggleable">-</button>
                                         <button type="button" id="${addRowBTN}" class="btn some_crementButton addButton toggleable">+</button>
                                         <button type="button" id="${delSeatsInRowBTN}" class="btn some_crementButton delButton toggleable">-</button>
                                         <button type="button" id="${addSeatsInBTN}" class="btn some_crementButton addButton toggleable">+</button>
                                     </div>
                                 </div>
                                 <div class="zone_sector">`;

                    for (let row of sector.rows) {

                        htmlText += `<div class="sector_row">`;
                        for (let seat of row.seats) {
                            let seatID = `setSeatStatusBTN${seatCounter}`
                            if (seat.available === true) {
                                htmlText += `<div id="${seatID}" class="row_seat"><button type="button" class="seat-btn"></button></div>`;
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

                let addSectorBTN = `addSectorBTN${zoneId}`;
                htmlText += `<button id="${addSectorBTN}" class="btn aCreate toggleable">Создать сектор</button>
                             </div>`; // конец class_zone
                zoneCounter++;
            }
            htmlText += `</div></div>`; // конец class_zones и plane_class
            classCounter++;
        }
        return htmlText;
    }

    printSeatShablonFromObject_AddButtonListeners_withoutBlocker(seatStructureObject)
    {
        let classCounter = 0;
        for (let planeClass of seatStructureObject.classes) {

            this.addDelClassButtonListener(seatStructureObject, planeClass, classCounter);
            this.addAddZoneButtonListener(seatStructureObject, planeClass, classCounter);

            let zoneCounter = 0;

            for (let zone of planeClass.zones) {

                let zoneId = `${classCounter}_${zoneCounter}`;
                this.addDelZoneButtonListener(seatStructureObject, planeClass, zone, zoneId);
                this.addCopyZoneButtonListener(seatStructureObject, planeClass, zone, zoneId);
                this.addAddSectorButtonListener(seatStructureObject, zone, zoneId);

                let sectorCounter = 0;


                for (let sector of zone.sectors) {

                    let sectorID = `${classCounter}_${zoneCounter}_${sectorCounter}`;

                    this.addDelSectorButtonListener(seatStructureObject, zone, sector, sectorID);
                    this.addCopySectorButtonListener(seatStructureObject, zone, sector, sectorID);


                    this.addDelRowButtonListener(seatStructureObject, sector, sectorID);
                    this.addAddRowButtonListener(seatStructureObject, sector, sectorID);
                    this.addDelSeatsInRowButtonListener(seatStructureObject, sector, sectorID);
                    this.addAddSeatsInRowButtonListener(seatStructureObject, sector, sectorID)

                    for (let row of sector.rows) {

                        for (let seat of row.seats) {

                        }

                    }


                    sectorCounter++;
                }
                zoneCounter++;
            }
            classCounter++;
        }

    }

    printSeatShablonFromObject_AddButtonListeners_withBlocker(seatStructureObject)
    {
        let classCounter = 0;
        let seatCounter = 0;

        for (let planeClass of seatStructureObject.classes) {

            this.addDelClassButtonListener(seatStructureObject, planeClass, classCounter);
            this.addAddZoneButtonListener(seatStructureObject, planeClass, classCounter);

            let zoneCounter = 0;

            for (let zone of planeClass.zones) {

                let zoneId = `${classCounter}_${zoneCounter}`;
                this.addDelZoneButtonListener(seatStructureObject, planeClass, zone, zoneId);
                this.addCopyZoneButtonListener(seatStructureObject, planeClass, zone, zoneId);
                this.addAddSectorButtonListener(seatStructureObject, zone, zoneId);

                let sectorCounter = 0;


                for (let sector of zone.sectors) {

                    let sectorID = `${classCounter}_${zoneCounter}_${sectorCounter}`;

                    this.addDelSectorButtonListener(seatStructureObject, zone, sector, sectorID);
                    this.addCopySectorButtonListener(seatStructureObject, zone, sector, sectorID);


                    this.addDelRowButtonListener(seatStructureObject, sector, sectorID);
                    this.addAddRowButtonListener(seatStructureObject, sector, sectorID);
                    this.addDelSeatsInRowButtonListener(seatStructureObject, sector, sectorID);
                    this.addAddSeatsInRowButtonListener(seatStructureObject, sector, sectorID)

                    for (let row of sector.rows) {

                        for (let seat of row.seats) {
                            this.addSetSeatStatusButtonListener(seatStructureObject, seat, seatCounter);
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

    addDelClassButtonListener(seatStructureObject, planeClass, classCounter)
    {
        let delClassBtnId = `delClassBTN${classCounter}`;
        let delClassBtn = document.getElementById(delClassBtnId);

        delClassBtn.addEventListener('click', () => {
            seatStructureObject.delClass(planeClass);
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addAddZoneButtonListener(seatStructureObject, planeClass, classCounter)
    {
        let addZoneBtnId = `addZoneBTN${classCounter}`;
        let addZoneBtn = document.getElementById(addZoneBtnId);

        addZoneBtn.addEventListener('click', () => {
            planeClass.addZone();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addDelZoneButtonListener(seatStructureObject, planeClass, zone, zoneId)
    {
        let delZoneBtnId = `delZoneBTN${zoneId}`;
        let delZoneBtn = document.getElementById(delZoneBtnId);

        delZoneBtn.addEventListener('click', () => {
            planeClass.delZone(zone);
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addCopyZoneButtonListener(seatStructureObject, planeClass, zone, zoneId)
    {
        let delZoneBtnId = `copyZoneBTN${zoneId}`;
        let delZoneBtn = document.getElementById(delZoneBtnId);

        delZoneBtn.addEventListener('click', () => {
            planeClass.addZoneCopy(zone);
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addAddSectorButtonListener(seatStructureObject, zone, sectorID)
    {
        let delZoneBtnId = `addSectorBTN${sectorID}`;
        let delZoneBtn = document.getElementById(delZoneBtnId);

        delZoneBtn.addEventListener('click', () => {
            zone.addSector();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addDelSectorButtonListener(seatStructureObject, zone, sector, sectorID)
    {
        let delSectorBtnId = `delSectorBTN${sectorID}`;
        let delSectorBtn = document.getElementById(delSectorBtnId);

        delSectorBtn.addEventListener('click', () => {
            zone.delSector(sector);
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addCopySectorButtonListener(seatStructureObject, zone, sector, sectorID)
    {
        let copySectorBTNId = `copySectorBTN${sectorID}`;
        let copySectorBTN = document.getElementById(copySectorBTNId);

        copySectorBTN.addEventListener('click', () => {
            zone.addSectorCopy(sector);
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addDelRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let delRowBTNId = `delRowBTN${sectorID}`;
        let delRowBTN = document.getElementById(delRowBTNId);

        delRowBTN.addEventListener('click', () => {
            sector.delLastRow();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addAddRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let addRowBTNId = `addRowBTN${sectorID}`;
        let addRowBTN = document.getElementById(addRowBTNId);

        addRowBTN.addEventListener('click', () => {
            if (!sector.rows.length){ // Пуст
                sector.addNewRow();
            } else {
                sector.addRowCopy(sector.rows[0]);
            }
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addDelSeatsInRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let delSeatsInRowBTNId = `delSeatsInRowBTN${sectorID}`;
        let delSeatsInRowBTN = document.getElementById(delSeatsInRowBTNId);

        delSeatsInRowBTN.addEventListener('click', () => {
            for (let row of sector.rows){
                row.delLastSeat();
            }
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addAddSeatsInRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let addSeatsInRowBTNID = `addSeatsInRowBTN${sectorID}`;
        let addSeatsInRowBTN = document.getElementById(addSeatsInRowBTNID);

        addSeatsInRowBTN.addEventListener('click', () => {
            for (let row of sector.rows){
                row.addSeat();
            }
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addSetSeatStatusButtonListener(seatStructureObject, seat, seatCounter)
    {
        let SetSeatStatusBtnId = `setSeatStatusBTN${seatCounter}`;
        let SetSeatStatusBTN = document.getElementById(SetSeatStatusBtnId);

        SetSeatStatusBTN.addEventListener('click', () => {
            // console.log(seat);
            let newStatus = !seat._available;

            seat._available = newStatus;
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    clearSeatShablonVisual(seatStructureObject)
    {
        this.visualDiscription.innerHTML = '';
    }


}

