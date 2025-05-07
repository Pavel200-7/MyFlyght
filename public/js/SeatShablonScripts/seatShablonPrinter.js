export class seatShablonPrinter
{
    constructor(visualDiscription)
    {
        this.visualDiscription = visualDiscription;
    }

    updateSeatShablonVisualFromJSON(seatStructure)
    {
        this.clearSeatShablonVisual();
        this.printSeatShablonFromJSON(seatStructure);
    }

    printSeatShablonFromJSON(seatStructureJSON)
    {
        let classCounter = 1;
        let htmlText = ``;

        for (let planeClass of seatStructureJSON['classes'])
        {
            let classType = planeClass['classType'];
            htmlText += `<div class="plane_class">
                                            <div class="tablo">
                                                <h1>Класс номер: ${classCounter}, тип: ${classType}</h1>
                                            </div>
                                         <div class="class_zones">`;
            for (let zone of planeClass['zones'])
            {
                htmlText += `<div class="class_zone">`;
                for (let sector of zone['sectors'])
                {
                    htmlText += `<div class="zone_sector">`;
                    for (let row=0; row<sector['rowCount']; row++)
                    {
                        htmlText += `<div class="sector_row">`;
                        for (let seats=0; seats<sector['seatsInRow']; seats++)
                        {
                            htmlText += `<div class="row_seat"><button></button></div>`;
                        }
                        htmlText += `</div>`;
                    }
                    htmlText += `</div>`;
                }
                htmlText += `</div>`;
            }
            htmlText += `</div>
                                         </div>`;
            classCounter++;
        }
        this.visualDiscription.innerHTML = htmlText;
    }

    updateSeatShablonVisualFromObject(seatStructure)
    {
        this.clearSeatShablonVisual();
        this.printSeatShablonFromObject(seatStructure);
    }

    printSeatShablonFromObject(seatStructureObject) {
        let classCounter = 1;
        let htmlText = ``;

        for (let planeClass of seatStructureObject.classes) {
            const classType = planeClass.classType;
            htmlText += `<div class="plane_class">
                        <div class="tablo">
                            <h1>Класс номер: ${classCounter}, тип: ${classType}</h1>
                        </div>
                        <div class="class_zones">`;

            for (let zone of planeClass.zones) {
                htmlText += `<div class="class_zone">`;

                for (let sector of zone.sectors) {
                    htmlText += `<div class="zone_sector">`;

                    for (let row = 0; row < sector.rowCount; row++) {
                        htmlText += `<div class="sector_row">`;
                        for (let seat = 0; seat < sector.seatsInRow; seat++) {
                            htmlText += `<div class="row_seat"><button></button></div>`;
                        }
                        htmlText += `</div>`;
                    }

                    htmlText += `</div>`; // конец zone_sector
                }

                htmlText += `</div>`; // конец class_zone
            }

            htmlText += `</div></div>`; // конец class_zones и plane_class
            classCounter++;
        }

        this.visualDiscription.innerHTML = htmlText;
    }

    clearSeatShablonVisual()
    {
        this.visualDiscription.innerHTML = '';
    }

}

