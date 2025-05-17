import { seatStructure } from "/js/SeatShablonScripts/seatStructureClasses/seatStructure.js";
import { planeClass } from "/js/SeatShablonScripts/seatStructureClasses/planeClass.js";
import { classZone } from "/js/SeatShablonScripts/seatStructureClasses/classZone.js";
import { zoneSector } from "/js/SeatShablonScripts/seatStructureClasses/zoneSector.js";
import { sectorRow } from "/js/SeatShablonScripts/seatStructureClasses/sectorRow.js";
import { rowSeat } from "/js/SeatShablonScripts/seatStructureClasses/rowSeat.js";

export class jsonConverter {
    parseSeatStructure(jsonData) {
        const seatStructureObj = new seatStructure();


        // Перебираем все классы
        jsonData.classes.forEach(cls => {
            const planeClassObj = new planeClass(cls.classType);

            // Перебираем зоны внутри класса
            cls.zones.forEach(zoneData => {
                const zoneObj = new classZone();

                // Перебираем сектора внутри зоны
                zoneData.sectors.forEach(sectorData => {
                    const sectorObj = new zoneSector();


                    sectorData.rows.forEach(rowData => {
                        const rowObj = new sectorRow();

                         // Внутренний уровень - массив rows (что содержит массив seats)
                        rowData.seats.forEach(seatsData => {
                            const seatObj = new rowSeat();

                            let status = true;
                            if (seatsData.seatStatus !== true) {
                                status = false;
                            }
                            let seatId = seatsData.seatID;

                            seatObj._available = status;
                            seatObj._seatId = seatId;

                            rowObj.addSeatCopy(seatObj); // добавляем сиденье в ряд

                        });

                        sectorObj.addRowCopy(rowObj); // добавляем ряд в сектор

                    });
                    zoneObj.addSectorCopy(sectorObj); // добавляем сектор в зону

                });

                planeClassObj.addZoneCopy(zoneObj); // добавляем зону в класс

            });
            seatStructureObj.addClassCopy(planeClassObj);

        });

        return seatStructureObj;
    }
}