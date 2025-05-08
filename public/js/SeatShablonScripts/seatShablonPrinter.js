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
        this.printSeatShablonFromObject_AddButtonListeners(seatStructureObject);
    }

    printSeatShablonFromObject_GetHTML(seatStructureObject)
    {
        let classCounter = 0;
        let htmlText = ``;

        for (let planeClass of seatStructureObject.classes) {

            let classType = planeClass.classType;
            let delClassBtnId = `delClassBTN${classCounter}`;
            let addZoneBtnId = `addZoneBTN${classCounter}`;
            let readableClassCounter = classCounter + 1;

            htmlText += `<div class="plane_class">
                        <div class="tablo">
                            <h1>Класс номер: ${readableClassCounter}, тип: ${classType}</h1>
                            <button id="${delClassBtnId}" class="btn aDelete toggleable">Удалить класс</button>
                            <button id="${addZoneBtnId}" class="btn aCreate toggleable">Добавить зону</button>
                        </div>
                        <div class="class_zones">`;

            let zoneCounter = 0;

            for (let zone of planeClass.zones) {

                let zoneId = `${classCounter}_${zoneCounter}`;
                let delZoneBtnId = `delZoneBTN${zoneId}`;
                let copyZoneBtnId = `copyZoneBTN${zoneId}`;

                htmlText += `<div class="class_zone">
                            <button id="${delZoneBtnId}" class="btn aDelete toggleable">Удалить зону</button>
                            <button id="${copyZoneBtnId}" class="btn aUpdate toggleable">Копировать зону</button>`;

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
                                     <button id="${delSectorBTN}" class="btn aDelete toggleable">Удалить сектор</button>
                                     <button id="${copySectorBTN}" class="btn aUpdate toggleable">Копировать сектор</button>
                                     <div>
                                         <button id="${delRowBTN}" class="btn some_crementButton delButton toggleable">-</button>
                                         <button id="${addRowBTN}" class="btn some_crementButton addButton toggleable">+</button>
                                         <button id="${delSeatsInRowBTN}" class="btn some_crementButton delButton toggleable">-</button>
                                         <button id="${addSeatsInBTN}" class="btn some_crementButton addButton toggleable">+</button>
                                     </div>
                                 </div>
                                 <div class="zone_sector">`;

                    for (let row = 0; row < sector.rowCount; row++) {

                        htmlText += `<div class="sector_row">`;
                        for (let seat = 0; seat < sector.seatsInRow; seat++) {
                            htmlText += `<div class="row_seat"><button></button></div>`;
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

    printSeatShablonFromObject_AddButtonListeners(seatStructureObject)
    {
        let classCounter = 0;
        // console.log(seatStructureObject);
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
            sector.decreaseRowInSector();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addAddRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let addRowBTNId = `addRowBTN${sectorID}`;
        let addRowBTN = document.getElementById(addRowBTNId);

        addRowBTN.addEventListener('click', () => {
            sector.increaseRowInSector();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addDelSeatsInRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let delSeatsInRowBTNId = `delSeatsInRowBTN${sectorID}`;
        let delSeatsInRowBTN = document.getElementById(delSeatsInRowBTNId);

        delSeatsInRowBTN.addEventListener('click', () => {
            sector.decreaseSeatsInRow();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }

    addAddSeatsInRowButtonListener(seatStructureObject, sector, sectorID)
    {
        let addSeatsInRowBTNID = `addSeatsInRowBTN${sectorID}`;
        let addSeatsInRowBTN = document.getElementById(addSeatsInRowBTNID);

        addSeatsInRowBTN.addEventListener('click', () => {
            sector.increaseSeatsInRow();
            this.updateSeatShablonVisualFromObject(seatStructureObject);
        });

    }







    clearSeatShablonVisual(seatStructureObject)
    {
        this.visualDiscription.innerHTML = '';
    }

}

