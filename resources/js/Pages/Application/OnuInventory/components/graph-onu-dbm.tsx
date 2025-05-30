"use client";

import {
    Area,
    AreaChart,
    CartesianGrid,
    XAxis,
    ResponsiveContainer,
    YAxis,
} from "recharts";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    ChartConfig,
    ChartContainer,
    ChartLegend,
    ChartLegendContent,
    ChartTooltip,
    ChartTooltipContent,
} from "@/components/ui/chart";
import { GPonOnusDBMInterface } from "@/types/onu-names";

const chartConfig = {
    desktop: {
        label: "TXDBM",
        color: "hsl(var(--chart-1))",
    },
    mobile: {
        label: "RXDBM",
        color: "hsl(var(--chart-2))",
    },
} satisfies ChartConfig;

export function GraphOnuDBM({
    collections,
}: {
    collections: GPonOnusDBMInterface[];
}) {
    if (collections.length <= 0) {
        return (
            <Card className="w-full mx-auto !rounded-md bg-sidebar">
                <CardHeader>
                    <CardTitle>Histórico e DBM</CardTitle>
                    <CardDescription></CardDescription>
                </CardHeader>
                <CardContent className="h-[15rem] sm:h-[20rem] flex justify-center items-center">
                    <p className="text-muted-foreground text-xl">
                        Nenhum registro carregado
                    </p>
                </CardContent>
            </Card>
        );
    }

    return (
        <Card className="w-full mx-auto !rounded-md bg-sidebar">
            <CardHeader>
                <CardTitle>Histórico e DBM</CardTitle>
                <CardDescription></CardDescription>
            </CardHeader>
            <CardContent className="h-[15rem] sm:h-[20rem]">
                <ChartContainer config={chartConfig} className="w-full h-full">
                    <ResponsiveContainer width="100%" height="100%">
                        <AreaChart
                            accessibilityLayer
                            data={collections}
                            margin={{
                                left: 12,
                                right: 12,
                            }}
                        >
                            <defs>
                                <linearGradient
                                    id="fillDesktop"
                                    x1="0"
                                    y1="0"
                                    x2="0"
                                    y2="1"
                                >
                                    <stop
                                        offset="5%"
                                        stopColor="var(--color-desktop)"
                                        stopOpacity={0.8}
                                    />
                                    <stop
                                        offset="95%"
                                        stopColor="var(--color-desktop)"
                                        stopOpacity={0.1}
                                    />
                                </linearGradient>
                                <linearGradient
                                    id="fillMobile"
                                    x1="0"
                                    y1="0"
                                    x2="0"
                                    y2="1"
                                >
                                    <stop
                                        offset="5%"
                                        stopColor="var(--color-mobile)"
                                        stopOpacity={0.8}
                                    />
                                    <stop
                                        offset="95%"
                                        stopColor="var(--color-mobile)"
                                        stopOpacity={0.1}
                                    />
                                </linearGradient>
                            </defs>

                            <CartesianGrid vertical={false} />
                            <XAxis
                                dataKey="COLLECTION_DATE"
                                tickLine={false}
                                axisLine={false}
                                tickMargin={8}
                                minTickGap={collections.length}
                                tickFormatter={(value) => value.slice(0, 3)}
                            />
                            <YAxis
                                domain={[-50, 50]} // Ajuste o domínio conforme seus dados
                                tickLine={false}
                                axisLine={false}
                            />
                            <ChartTooltip
                                cursor={false}
                                content={
                                    <ChartTooltipContent indicator="line" />
                                }
                            />
                            <Area
                                dataKey="TXDBM"
                                type="natural"
                                fill="var(--color-desktop)"
                                fillOpacity={0.4}
                                stroke="var(--color-desktop)"
                                stackId="a"
                            />
                            <Area
                                dataKey="RXDBM"
                                type="natural"
                                fill="var(--color-mobile)"
                                fillOpacity={0.4}
                                stroke="var(--color-mobile)"
                                stackId="a"
                            />

                            <ChartLegend content={<ChartLegendContent />} />
                        </AreaChart>
                    </ResponsiveContainer>
                </ChartContainer>
            </CardContent>
        </Card>
    );
}
