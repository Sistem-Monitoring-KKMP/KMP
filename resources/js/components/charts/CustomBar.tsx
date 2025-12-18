import { Bar } from 'reaviz';
import { useState, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

export type CustomBarProps = ComponentProps<typeof Bar>;

export const CustomBar = (props: CustomBarProps) => {
    const [hovered, setHovered] = useState(false);
    const { ...rest } = props;

    return (
        <Bar
            {...rest}
            active={hovered}
            onMouseEnter={(e) => {
                setHovered(true);
                rest.onMouseEnter?.(e);
            }}
            onMouseLeave={(e) => {
                setHovered(false);
                rest.onMouseLeave?.(e);
            }}
            style={{
                ...rest.style,
                cursor: 'pointer',
                stroke: hovered ? CHART_COLORS.HOVER_STROKE : 'none',
                strokeWidth: hovered ? 2 : 0,
                filter: hovered ? 'brightness(1.1)' : 'none'
            }}
        />
    );
};
