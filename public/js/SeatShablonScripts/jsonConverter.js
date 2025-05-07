import { ClassZone } from "/js/SeatShablonScripts/seatStructureClasses/classZone.js";
import { PlaneClass } from "/js/SeatShablonScripts/seatStructureClasses/planeClass.js";
import { SeatStructure } from "/js/SeatShablonScripts/seatStructureClasses/seatStructure.js";
import { ZoneSector } from "/js/SeatShablonScripts/seatStructureClasses/zoneSector.js";

export class jsonConverter
{
    parseSeatStructure(jsonData)
    {
    const seatStructure = new SeatStructure();

    jsonData.classes.forEach(cls => {
        const planeClass = new PlaneClass(cls.classType);

        cls.zones.forEach(zoneData => {
            const zone = new ClassZone();

            zoneData.sectors.forEach(sectorData => {
                const sector = new ZoneSector()
                    .setRowCount(sectorData.rowCount)
                    .setSeatsInRow(sectorData.seatsInRow);
                // zone.addSectorCopy(sector);
            });

            // planeClass.addZoneCopy(zone);
        });

        seatStructure.addClassCopy(planeClass);
    });

    return seatStructure;
    }

}