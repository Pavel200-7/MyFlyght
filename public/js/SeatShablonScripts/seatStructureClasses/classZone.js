import { ZoneSector } from "/js/SeatShablonScripts/seatStructureClasses/zoneSector.js";
export class ClassZone {
    constructor() {
        this.sectors = [];
        this.addSector(); // Изначально создаем один сектор
    }

    getSectors() {
        return this.sectors;
    }

    setSectors(sectors) {
        this.sectors = sectors;
        return this;
    }

    addSector() {
        this.sectors.push(new ZoneSector());
        return this;
    }

    addSectorCopy(zoneSector) {
        this.sectors.push(zoneSector);
        return this;
    }

    delSector(zoneSector) {
        const index = this.sectors.indexOf(zoneSector);
        if (index !== -1) {
            this.sectors.splice(index, 1);
        }
        return this;
    }
}