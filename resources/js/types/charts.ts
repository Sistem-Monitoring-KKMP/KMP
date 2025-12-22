export interface SeriesConfig {
    key: string;
    label: string;
    color?: string;
}

export interface SingleSeriesPoint {
    key: Date;
    data: number;
}

export interface GroupedSeries {
    key: string;
    data: SingleSeriesPoint[];
}
