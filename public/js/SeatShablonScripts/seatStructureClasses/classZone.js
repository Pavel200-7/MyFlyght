import { zoneSector } from "/js/SeatShablonScripts/seatStructureClasses/zoneSector.js";
export class classZone {
    constructor() {
        this.sectors = [];
        // this.addSector(); // Изначально создаем один сектор
    }

    deepClone() {
        const clone = new classZone();
        clone.sectors = this.sectors.map(sector => sector.deepClone());
        return clone;
    }

    getSectors() {
        return this.sectors;
    }

    setSectors(sectors) {
        this.sectors = sectors;
        return this;
    }

    addSector() {
        this.sectors.push(new zoneSector());
        return this;
    }

    addSectorCopy(zoneSector) {
        let objectCopy = zoneSector.deepClone();
        this.sectors.push(objectCopy);
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