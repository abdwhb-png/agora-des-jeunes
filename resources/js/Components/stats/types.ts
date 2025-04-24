export interface BaseStatsProps {
    loading?: boolean;
    error?: string | null;
    darkMode?: boolean;
}

export interface StatValue {
    value: number;
    label: string;
    change?: number; // Percentage change from previous period
    trend?: "up" | "down" | "neutral";
}

export interface ChartData {
    labels: string[];
    datasets: {
        label: string;
        data: number[];
        backgroundColor?: string;
        borderColor?: string;
        borderWidth?: number;
    }[];
}

export interface UserStats extends BaseStatsProps {
    totalUsers?: StatValue;
    activeUsers?: StatValue;
    newUsers?: StatValue;
    chartData?: ChartData;
}

export interface ActivityStats extends BaseStatsProps {
    totalActivities?: StatValue;
    completionRate?: StatValue;
    avgDuration?: StatValue;
    chartData?: ChartData;
}

export interface PaginationState {
    currentPage: number;
    itemsPerPage: number;
    totalItems: number;
}

export interface GeographicStats extends BaseStatsProps {
    quartiers?: StatValue[];
    cities?: StatValue[];
    arrondissements?: StatValue[];
    chartDatas?: ChartData;
    quartiersPagination?: PaginationState;
    citiesPagination?: PaginationState;
}

export interface CareerStats extends BaseStatsProps {
    jobPlacements?: StatValue;
    trainingCompleted?: StatValue;
    certifications?: StatValue;
    chartData?: ChartData;
}

export interface PollStats extends BaseStatsProps {
    totalPolls?: StatValue;
    activePolls?: StatValue;
    totalVotes?: StatValue;
    chartData?: ChartData;
}
